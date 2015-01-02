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
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;
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
        // Set form
        $form = new ContactForm('contact');
        // Get post
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
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
                Pi::api('mail', 'contact')->toAdmin($values);
                Pi::api('mail', 'contact')->toUser($values);
                // Set finish
                $finishText = (!empty($config['finishtext'])) 
                    ? $config['finishtext'] 
                    : __('Message correctly Send, a confirmation has just been sent to you by email');
                $this->view()->assign('finish', 1);
                $this->view()->assign('finishText', $finishText);
            }
        } else {
            // Set data
            $data = array(
                'department' => $config['default_department']
            );
        }
        // Set data
        $form->setData($data);
        // Set view
        $this->view()->headTitle($config['index_seo_title']);
        $this->view()->headDescription($config['index_seo_description'], 'set');
        $this->view()->headKeywords($config['index_seo_keywords'], 'set');
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
        // Set form
        $form = new ContactForm('contact');
        // Get post
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
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
                Pi::api('mail', 'contact')->toAdmin($values);
                Pi::api('mail', 'contact')->toUser($values);
                // Set finish
                $finishText = (!empty($config['finishtext'])) 
                    ? $config['finishtext'] 
                    : __('Message correctly Send, a confirmation has just been sent to you by email');
                $this->view()->assign('finish', 1);
                $this->view()->assign('finishText', $finishText);
            }
        } else {
            // Set data
            $data = array(
                'department' => $department['id']
            );
        }
        // Set data
        $form->setData($data);
        // Set seo_keywords
        $filter = new Filter\HeadKeywords;
        $filter->setOptions(array(
            'force_replace_space' => true
        ));
        $seoKeywords = $filter($department['title']);
        // Set view
        $this->view()->headTitle($department['title']);
        $this->view()->headDescription($department['title'], 'set');
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
            $list[$row->id]['url'] = Pi::url($this->url('', array('module' => $module, 'department' => $list[$row->id]['slug'])));
        }
        // Set view
        $this->view()->headTitle($config['list_seo_title']);
        $this->view()->headDescription($config['list_seo_description'], 'set');
        $this->view()->headKeywords($config['list_seo_keywords'], 'set');
        $this->view()->setTemplate('index_list');
        $this->view()->assign('title', __('List of departments'));
        $this->view()->assign('lists', $list);
        $this->view()->assign('config', $config);
    }
    
    public function ajaxAction()
    {
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Set info
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
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
                // Set values
                $values['author'] = isset($values['author']) ? $values['author'] : 0;
                $values['department'] = isset($values['department']) ? $values['department'] : $config['default_department'];
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
			    Pi::api('mail', 'contact')->toAdmin($values);
                Pi::api('mail', 'contact')->toUser($values);
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
}