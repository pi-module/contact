<?php
/**
 * Contact admin message controller
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Hossein Azizabadi <azizabadi@faragostaresh.com>
 * @since           3.0
 * @package         Module\Contact
 * @version         $Id$
 */

namespace Module\Contact\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Contact\Form\ReplyForm;
use Module\Contact\Form\ReplyFilter;

class MessageController extends ActionController
{
    protected $messageColumns = array(
        'id', 'subject', 'department', 'email', 'name', 'organization', 'homepage', 'location',
        'phone', 'ip', 'address', 'message', 'mid', 'answered', 'author', 'create', 'platform'
    );

    public function indexAction()
    {
        // Get page
        $page = $this->params('p', 1);
        // Set info
        $where = array('mid' => 0);
        $columns = array('id', 'subject', 'department', 'name', 'author', 'create', 'answered');
        $order = array('id DESC', 'create DESC');
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $limit = intval($this->config('admin_perpage'));
        //  Get department
        $department = $this->params('department');
        if (!empty($department)) {
            $where['department'] = $department;
            $this->view()->assign('department', 1);
        }
        // Get department list
        $select = $this->getModel('department')->select()->columns(array('id', 'title'))->order(array('id DESC'));
        $rowset = $this->getModel('department')->selectWith($select);
        // Make department list
        foreach ($rowset as $row) {
            $departmentList[$row->id] = $row->toArray();
        }
        // Get info
        $select = $this->getModel('message')->select()->where($where)->columns($columns)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('message')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $message[$row->id] = $row->toArray();
            $message[$row->id]['departmenttitle'] = $departmentList[$row->department]['title'];
            $message[$row->id]['create'] = _date($message[$row->id]['create']);
        }
        // Set paginator
        $select = $this->getModel('message')->select()->where($where)->columns(array('count' => new \Zend\Db\Sql\Predicate\Expression('count(*)')));
        $count = $this->getModel('message')->selectWith($select)->current()->count;
        $paginator = \Pi\Paginator\Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            // Use router to build URL for each page
            'pageParam' => 'p',
            'totalParam' => 't',
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array(
                'module' => $this->getModule(),
                'controller' => 'message',
                'action' => 'index',
            ),
            // Or use a URL template to create URLs
            //'template'      => '/url/p/%page%/t/%total%',

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
        // Get department
        $department = $this->getModel('department')->find($message->department);
        // Get Main message if this message is answer
        if ($message->mid) {
            $main = $this->getModel('message')->find($message->mid);
            $this->view()->assign('main', $main);
        }
        // Get all answeres to this message
        if ($message->answered) {
            $select = $this->getModel('message')->select()->where(array('mid' => $message->id))->columns(array('id', 'subject', 'create'))->order(array('create DESC', 'id DESC'));
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
                $values['ip'] = getenv('REMOTE_ADDR');
                $values['create'] = time();
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
                $this->sendMail($values);
                if ($row->id) {
                    $alert = __('Your reply Send and saved successfully');
                    $this->jump(array('action' => 'index'), $alert);
                } else {
                    $alert = __('Your reply send successfully but dont saved in DB');
                }
            } else {
                $alert = __('Error in send reply as Email');
            }
        } else {
            // Set values
            $values = array(
                'author' => Pi::registry('user')->id,
                'mid' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => sprintf(__('Re : %s'), $message->subject),
            );
            $form->setData($values);
            $alert = __('You can answer to this message');
        }
        // Set view
        $this->view()->setTemplate('message_reply');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', sprintf(__('Reply to %s'), $message->subject));
        $this->view()->assign('message', $message);
        $this->view()->assign('alert', $alert);
    }

    public function deleteAction()
    {
        /*
           * not completed and need confirm option
           */
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
    
    protected function sendMail($values)
    {
        // Set to
        $to = array(
            $values['email'] => $values['name'],
        );
        
        // Set template info
        $values['create'] = _date($values['create']);
        
        // Set template
        $data = Pi::service('mail')->template('reply', $values);
        
        // Set subject and body
        $subject = $data['subject'];
        $body = $data['body'];
        $type = $data['format'];
        
        // Set message
        $message = Pi::service('mail')->message($subject, $body, $type);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        
        // Send mail
        $result = Pi::service('mail')->send($message);
        
        // Return
        return $result;
        
        
    }
}