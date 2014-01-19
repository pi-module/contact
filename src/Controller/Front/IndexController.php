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
namespace Module\Contact\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Db\RowGateway\RowGateway;
use Module\Contact\Form\ContactForm;
use Module\Contact\Form\ContactFilter;
use Zend\Json\Json;

class IndexController extends ActionController
{
    protected $messageColumns = array(
        'id', 'subject', 'department', 'email', 'name', 'organization', 'homepage', 'location',
        'phone', 'ip', 'address', 'message', 'mid', 'answered', 'uid', 'time_create', 'platform'
    );

    public function indexAction()
    {
        if (!$this->params('department') && $this->config('homepage') == 'list') {
            $this->renderList();
        } else {
            $this->renderForm();
        }
    }

    public function finishAction()
    {
        // Set info
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set view
        $this->view()->headTitle(__('Contact Us'));
        $this->view()->setTemplate('index_finish');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('message', __('Contact Us'));
        $this->view()->assign('config', $config);
    }
    
    public function ajaxAction() {
        // Set info
        $module = $this->params('module');
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Set return array
        $return = array();
        // Check post
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form = new ContactForm('contact');
            $form->setInputFilter(new ContactFilter);
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
			    // Save
			    $row = $this->getModel('message')->createRow();
			    $row->assign($values);
			    $row->save();
			    // Set department
			    $department = $this->getModel('department')->find($values['department'])->toArray();
			    $values['department_title'] = $department['title'];
			    $values['department_email'] = $department['email'];
			    // Send as mail
			    $this->sendMail($values);
			    // return
			    $return['message'] = __('Your Contact send and saved successfully');
			    $return['submit'] = 1;
            } else {
			    $return['message'] = __('Send information not valid');
			    $return['submit'] = 0;
            }	
        } else {
            $return['message'] = __('Nothing send');
            $return['submit'] = 0;
        }
        // Return
        return Json::encode($return);
    }	

    protected function sendMail($values)
    {
        // Set to
        $to = array(
            Pi::config('adminmail', 'mail')  => Pi::config('adminname', 'mail'),
            $values['department_email']      => $values['department_title'],
        );
        // Set template info
        $values['time_create'] = _date($values['time_create']);
        // Set template
        $data = Pi::service('mail')->template('contact', $values);
        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        // Send mail
        $result = Pi::service('mail')->send($message);
        // Return
        return $result;
    }

    protected function renderForm($data = null)
    {
        // Set info
        $module = $this->params('module');
        $department = $this->params('department');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set form department
        if ($department) {
            $row = $this->getModel('department')->find($department, 'slug');
            if (!$row instanceof RowGateway || !$row->status) {
                $data['department'] = $config['default_department'];
				$title = __('Contact Us');
            } else {
                $row = $row->toArray();
                $data['department'] = $row['id'];
				$title = $row['title'];
            }
        } else {
            $data['department'] = $config['default_department'];
            $title = __('Contact Us');
        }
        // Set form
        $form = new ContactForm('contact');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form = new ContactForm('contact');
            $form->setInputFilter(new ContactFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->messageColumns)) {
                        unset($values[$key]);
                    }
                }
                $values['ip'] = getenv('REMOTE_ADDR');
                $values['time_create'] = time();
                // Save
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();
                // Set department
                $department = $this->getModel('department')->find($values['department'])->toArray();
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];
                // Send as mail
                $this->sendMail($values);
                // Set jump
                $url = array('action' => 'finish');
                $message = __('Your Contact send and saved successfully');
                $this->jump($url, $message);
            } else {

            }
        } else {
            $form->setData($data);
        }
        // Set keywords
        $keywords = Pi::api('text', 'contact')->keywords($title);
        // Set Description
        $description = Pi::api('text', 'contact')->description($title);
        // Set view
        $this->view()->headTitle($title);
        $this->view()->headDescription($description, 'set');
        $this->view()->headKeywords($keywords, 'set');
        $this->view()->setTemplate('index_form');
        $this->view()->assign('title', $title);
        $this->view()->assign('form', $form);
        $this->view()->assign('config', $config);
    }

    protected function renderList()
    {
        // Set info
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // get department list
        $where = array('status' => 1);
        $order = array('id DESC');
        $select = $this->getModel('department')->select()->where($where)->order($order);
        $rowset = $this->getModel('department')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['url'] = $this->url('', array('module' => $module, 'department' => $list[$row->id]['slug']));
        }
        // Set keywords
        $keywords = Pi::api('text', 'contact')->keywords(__('Select Department Form contact us'));
        // Set Description
        $description = Pi::api('text', 'contact')->description(__('Select Department Form contact us'));
        // Set view
        $this->view()->headTitle(__('Contact Us'));
        $this->view()->headDescription($description, 'set');
        $this->view()->headKeywords($keywords, 'set');
        $this->view()->setTemplate('index_list');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('message', __('Select Department Form contact us'));
        $this->view()->assign('lists', $list);
        $this->view()->assign('config', $config);
    }
}