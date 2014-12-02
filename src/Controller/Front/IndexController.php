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
        // Set info
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Check
        if ($config['homepage'] == 'list') {
            return $this->redirect()->toRoute('', array(
                'action'     => 'list',
            ));
        }
        // Get post
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
                // Get department
                $department = $this->getModel('department')->find($values['department'])->toArray();
                // Set values
                $values['ip'] = Pi::user()->getIp();
                $values['time_create'] = time();
                // Save
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();
                // Set department
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];
                // Send as mail
                $this->sendMailToAdmin($values);
                $this->sendMailToUser($values);
                // Set jump
                $url = array('action' => 'finish', 'hash' => md5(time()));
                $message = __('Your Contact send and saved successfully');
                $this->jump($url, $message);
            }
        } else {
            // Set form
            $form = new ContactForm('contact');
            // Set data
            $data = array(
                'department' => $config['default_department']
            );
        }
        // Set data
        $form->setData($data);
        // Set seo text
        $seoTitle = Pi::api('text', 'contact')->title(__('Contact us form'));
        $seoKeywords = Pi::api('text', 'contact')->keywords(__('Contact us form'));
        $seoDescription = Pi::api('text', 'contact')->description(__('Contact us form'));
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('index_form');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('form', $form);
        $this->view()->assign('config', $config);
    }

    public function departmentAction()
    {
        // Set info
        $module = $this->params('module');
        $department = $this->params('department');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Check
        if ($config['homepage'] == 'list' && empty($department)) {
            return $this->redirect()->toRoute('', array(
                'action'     => 'list',
            ));
        }
        // Get department
        $department = $this->getModel('department')->find($department, 'slug')->toArray();
        // check department status
        if ($department['status'] != 1) {
            $url = array('action' => 'list');
            $message = __('Your selected department not active');
            $this->jump($url, $message);
        }
        // Get post
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
                // Set values
                $values['ip'] = Pi::user()->getIp();
                $values['time_create'] = time();
                // Save
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();
                // Set department
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];
                // Send as mail
                $this->sendMailToAdmin($values);
                $this->sendMailToUser($values);
                // Set jump
                $url = array('action' => 'finish', 'hash' => md5(time()));
                $message = __('Your Contact send and saved successfully');
                $this->jump($url, $message);
            }
        } else {
            // Set form
            $form = new ContactForm('contact');
            // Set data
            $data = array(
                'department' => $department['id']
            );
        }
        // Set data
        $form->setData($data);
        // Set seo text
        $seoTitle = Pi::api('text', 'contact')->title($department['title']);
        $seoKeywords = Pi::api('text', 'contact')->keywords($department['title']);
        $seoDescription = Pi::api('text', 'contact')->description($department['title']);
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('index_form');
        $this->view()->assign('title', $department['title']);
        $this->view()->assign('department', $department);
        $this->view()->assign('form', $form);
        $this->view()->assign('config', $config);
    }

    public function listAction()
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
        // Set seo text
        $seoTitle = Pi::api('text', 'contact')->title(__('List of departments'));
        $seoKeywords = Pi::api('text', 'contact')->keywords(__('Select Department Form contact us'));
        $seoDescription = Pi::api('text', 'contact')->description(__('Select Department Form contact us'));
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('index_list');
        $this->view()->assign('title', __('List of departments'));
        $this->view()->assign('lists', $list);
        $this->view()->assign('config', $config);
    }

    public function finishAction()
    {
        // Set info
        $module = $this->params('module');
        $hash = $this->params('hash');
        // Check hash
        if (empty($hash)) {
            $url = array('action' => 'index');
            $message = __('Please submit contact form');
            $this->jump($url, $message);
        }
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set seo text
        $seoTitle = Pi::api('text', 'contact')->title(__('Finish'));
        $seoKeywords = Pi::api('text', 'contact')->keywords(__('Submit contact form finished'));
        $seoDescription = Pi::api('text', 'contact')->description(__('Submit contact form finished'));
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('index_finish');
        $this->view()->assign('title', __('Finish'));
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
			    $values['ip'] = Pi::user()->getIp();
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
			    $this->sendMailToAdmin($values);
                $this->sendMailToUser($values);
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

    protected function sendMailToAdmin($values)
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
        Pi::service('mail')->send($message);
    }

    protected function sendMailToUser($values)
    {
        // Set to
        $to = array(
            $values['email']      => $values['name'],
        );
        // Set template info
        $values['time_create'] = _date($values['time_create']);
        // Set template
        $data = Pi::service('mail')->template('user', $values);
        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        // Send mail
        Pi::service('mail')->send($message);
    } 
}