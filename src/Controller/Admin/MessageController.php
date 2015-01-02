<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Contact\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Module\Contact\Form\ReplyForm;
use Module\Contact\Form\ReplyFilter;

class MessageController extends ActionController
{
    protected $messageColumns = array(
        'id', 'subject', 'department', 'email', 'name', 'organization', 'homepage', 'location',
        'phone', 'ip', 'address', 'message', 'mid', 'answered', 'uid', 'time_create', 'platform'
    );

    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        // Set info
        $where = array('mid' => 0);
        $order = array('id DESC', 'time_create DESC');
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $limit = intval($this->config('admin_perpage'));
        //  Get department
        $department = $this->params('department');
        if (!empty($department)) {
            $where['department'] = $department;
            $this->view()->assign('department', 1);
        }
        // Get department list
        $columns = array('id', 'title');
        $select = $this->getModel('department')->select()->columns($columns);
        $rowset = $this->getModel('department')->selectWith($select);
        // Make department list
        foreach ($rowset as $row) {
            $departmentList[$row->id] = $row->toArray();
        }
        // Get info
        $select = $this->getModel('message')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('message')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $message[$row->id] = $row->toArray();
            $message[$row->id]['departmenttitle'] = $departmentList[$row->department]['title'];
            $message[$row->id]['time_create'] = _date($message[$row->id]['time_create']);
            // Get user info
            $user = Pi::user()->bind($row->uid);
            $message[$row->id]['user']['identity'] = $user->identity;
            $message[$row->id]['user']['name'] = $user->name;
            $message[$row->id]['user']['email'] = $user->email;
        }
        // Set paginator
        $count = array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)'));
        $select = $this->getModel('message')->select()->columns($count)->where($where);
        $count = $this->getModel('message')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'message',
                'action'        => 'index',
                'department'    => $department,
            )),
        ));
        // Set view
        $this->view()->setTemplate('message_index');
        $this->view()->assign('messages', $message);
        $this->view()->assign('paginator', $paginator);
    }

    public function viewAction()
    {
        // Set template
        $this->view()->setTemplate('message_view');
        //  Get message
        $id = $this->params('id');
        $message = $this->getModel('message')->find($id);
        // Check message
        if (!$message->id) {
            $this->jump(array('action' => 'index'), __('Please select message'));
        }
        // to array
        $message = $message->toArray();
        // Set user info
        $user = Pi::user()->bind($message['uid']);
        $message['user']['identity'] = $user->identity;
        $message['user']['name'] = $user->name;
        $message['user']['email'] = $user->email;
        // Set date
        $message['time_create'] = _date($message['time_create']);
        // Get department
        $department = $this->getModel('department')->find($message['department']);
        // Get Main message if this message is answer
        if ($message['mid']) {
            $main = $this->getModel('message')->find($message['mid']);
            $this->view()->assign('main', $main);
        }
        // Get all answeres to this message
        if ($message['answered']) {
            $where = array('mid' => $message['id']);
            $columns = array('id', 'subject', 'time_create');
            $order = array('time_create DESC', 'id DESC');
            $select = $this->getModel('message')->select()->where($where)->columns($columns)->order($order);
            $rowset = $this->getModel('message')->selectWith($select);
            foreach ($rowset as $row) {
                $answer[$row->id] = $row->toArray();
            }
            $this->view()->assign('answers', $answer);
        }
        // Set view
        $this->view()->assign('department', $department);
        $this->view()->assign('message', $message);
    }

    public function replyAction()
    {
        //  Get message
        $id = $this->params('id');
        $message = $this->getModel('message')->find($id);
        // Check message
        if (!$message->id) {
            $this->jump(array('action' => 'index'), __('Please select message'));
        }
        // Set form
        $form = new ReplyForm('reply');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new ReplyFilter);
            $form->setData($data);
            if ($form->isValid()) {
                // Set values
                $values = $form->getData();
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->messageColumns)) {
                        unset($values[$key]);
                    }
                }
                $values['ip'] = Pi::user()->getIp();
                $values['time_create'] = time();
                $values['department'] = $message->department;
                // Save date
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();
                // update answerd
                $message->answered = 1;
                $message->save();
                 // Set department
                $department = $this->getModel('department')->find($message->department)->toArray();
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];
                // Send as mail
                Pi::api('mail', 'contact')->toReply($values);
                // Jump
                $this->jump(array('action' => 'index'), __('Your reply Send and saved successfully'));
            }
        } else {
            // Set values
            $values = array(
                'author'   => Pi::user()->getId(),
                'mid'      => $message->id,
                'name'     => $message->name,
                'email'    => $message->email,
                'subject'  => sprintf(__('Re : %s'), $message->subject),
            );
            $form->setData($values);
        }
        // Set title
        $title = sprintf(__('Reply to %s'), $message->subject);
        // Set view
        $this->view()->setTemplate('message_reply');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', $title);
        $this->view()->assign('message', $message);
    }

    public function deleteAction()
    {
        // Get information
        $this->view()->setTemplate(false);
        $id = $this->params('id');
        $row = $this->getModel('message')->find($id);
        if ($row) {
            // Remove answeres
            $this->getModel('message')->delete(array('mid' => $row->id));
            // Remove message
            $row->delete();
            $this->jump(array('action' => 'index'), __('Your selected message deleted'));
        }
        $this->jump(array('action' => 'index'), __('Please select message'));
    }
}