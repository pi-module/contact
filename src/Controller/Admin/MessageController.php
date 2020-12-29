<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\Contact\Controller\Admin;

use Module\Contact\Form\ReplyFilter;
use Module\Contact\Form\ReplyForm;
use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Laminas\Db\Sql\Predicate\Expression;

class MessageController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);

        // Set info
        $message = [];
        $where   = ['mid' => 0];
        $order   = ['id DESC', 'time_create DESC'];
        $offset  = (int)($page - 1) * $this->config('admin_perpage');
        $limit   = intval($this->config('admin_perpage'));

        //  Get department
        $department = $this->params('department');
        if (!empty($department)) {
            $where['department'] = $department;
            $this->view()->assign('department', 1);
        }

        // Get department list
        $columns = ['id', 'title'];
        $select  = $this->getModel('department')->select()->columns($columns);
        $rowset  = $this->getModel('department')->selectWith($select);
        foreach ($rowset as $row) {
            $departmentList[$row->id] = $row->toArray();
        }

        // Get info
        $select = $this->getModel('message')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('message')->selectWith($select);

        // Make list
        foreach ($rowset as $row) {
            $message[$row->id]                    = $row->toArray();
            $message[$row->id]['departmenttitle'] = $departmentList[$row->department]['title'];
            $message[$row->id]['time_create']     = _date($message[$row->id]['time_create']);

            // Get user info
            $message[$row->id]['user'] = [];
            if ($row->uid > 0) {
                $message[$row->id]['user'] = Pi::user()->get(
                    $row->uid,
                    [
                        'id', 'identity', 'name', 'email',
                    ]
                );
            }
        }

        // Set count
        $count  = ['count' => new Expression('count(*)')];
        $select = $this->getModel('message')->select()->columns($count)->where($where);
        $count  = $this->getModel('message')->selectWith($select)->current()->count;

        // Set paginator
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(
            [
                'router' => $this->getEvent()->getRouter(),
                'route'  => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
                'params' => array_filter(
                    [
                        'module'     => $this->getModule(),
                        'controller' => 'message',
                        'action'     => 'index',
                        'department' => $department,
                    ]
                ),
            ]
        );

        // Set view
        $this->view()->setTemplate('message-index');
        $this->view()->assign('messages', $message);
        $this->view()->assign('paginator', $paginator);
    }

    public function viewAction()
    {
        //  Get message
        $id      = $this->params('id');
        $message = $this->getModel('message')->find($id);

        // Check message
        if (!$message->id) {
            $this->jump(['action' => 'index'], __('Please select message'));
        }

        // to array
        $message = $message->toArray();

        // Set user info
        $user                        = Pi::user()->bind($message['uid']);
        $message['user']['identity'] = $user->identity;
        $message['user']['name']     = $user->name;
        $message['user']['email']    = $user->email;

        // Set date
        $message['time_create'] = _date($message['time_create']);

        // Get department
        $department = $this->getModel('department')->find($message['department']);

        // Get Main message if this message is answer
        if ($message['mid']) {
            $main = $this->getModel('message')->find($message['mid']);
            $this->view()->assign('main', $main);
        }

        // Get all answer's to this message
        if ($message['answered']) {
            $where   = ['mid' => $message['id']];
            $columns = ['id', 'subject', 'message', 'time_create', 'ip'];
            $order   = ['time_create ASC', 'id ASC'];
            $select  = $this->getModel('message')->select()->where($where)->columns($columns)->order($order);
            $rowset  = $this->getModel('message')->selectWith($select);
            foreach ($rowset as $row) {
                $answer[$row->id] = $row->toArray();
            }
            $this->view()->assign('answers', $answer);
        }

        // Set view
        $this->view()->setTemplate('message-view');
        $this->view()->assign('department', $department);
        $this->view()->assign('message', $message);
    }

    public function replyAction()
    {
        //  Get message
        $id      = $this->params('id');
        $message = $this->getModel('message')->find($id);

        // Check message
        if (!$message->id) {
            $this->jump(['action' => 'index'], __('Please select message'));
        }

        // Set options
        $options = [
            'sms_replay' => $this->config('sms_replay'),
        ];

        // Set form
        $form = new ReplyForm('reply', $options);
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new ReplyFilter($options));
            $form->setData($data);
            if ($form->isValid()) {

                // Set values
                $values                = $form->getData();
                $values['ip']          = Pi::user()->getIp();
                $values['time_create'] = time();
                $values['department']  = $message->department;
                $values['message']     = _strip($values['message']);

                // Save date
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();

                // update answerd
                $message->answered = 1;
                $message->save();

                // Set department
                $department                 = $this->getModel('department')->find($message->department)->toArray();
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];

                // Send as mail
                if ($this->config('sms_replay')) {
                    Pi::service('notification')->smsToUser($values['message'], $values['mobile']);
                } else {
                    Pi::api('mail', 'contact')->toReply($values);
                }

                // Jump
                $this->jump(['action' => 'index'], __('Your reply Send and saved successfully'));
            }
        } else {
            // Set mobile
            $mobile = '';
            if ($this->config('sms_replay') && $message->uid > 0) {
                $user   = Pi::user()->get(
                    $message->uid,
                    [
                        'id', 'identity', 'name', 'email', 'mobile',
                    ]
                );
                $mobile = $user['mobile'];
            }

            // Set values
            $values = [
                'uid'     => Pi::user()->getId(),
                'mid'     => $message->id,
                'name'    => $message->name,
                'email'   => $message->email,
                'mobile'  => $mobile,
                'subject' => sprintf(__('Re : %s'), $message->subject),
            ];
            $form->setData($values);
        }

        // Set title
        $title = sprintf(__('Reply to %s'), $message->subject);

        // Set view
        $this->view()->setTemplate('message-reply');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', $title);
        $this->view()->assign('message', $message);
    }

    public function deleteAction()
    {
        // Set view
        $this->view()->setTemplate(false);

        // Get information
        $id       = $this->params('id');
        $returnId = $this->params('returnId');

        // Get row
        $row = $this->getModel('message')->find($id);
        if ($row) {

            // Remove answeres
            $this->getModel('message')->delete(['mid' => $row->id]);

            // Remove message
            $row->delete();

            if ($returnId) {
                $this->jump(['action' => 'view', 'id' => $returnId], __('Your selected message deleted'));
            } else {
                $this->jump(['action' => 'index'], __('Your selected message deleted'));
            }
        }

        $this->jump(['action' => 'index'], __('Please select message'));
    }
}
