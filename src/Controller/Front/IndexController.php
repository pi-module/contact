<?php
/**
 * Contact index controller
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
        'phone', 'ip', 'address', 'message', 'mid', 'answered', 'author', 'create', 'platform'
    );

    public function indexAction()
    {
        if (!$this->params('department') && $this->config('homepage') == 'list') {
            $this->renderList();
        } else {
            $this->renderForm();
        }
    }

    public function saveAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form = new ContactForm('contact', $this->params('module'));
            $form->setInputFilter(new ContactFilter($this->params('module')));
            $form->setData($data);
            if (!$form->isValid()) {
                $this->view()->assign('message', __('Invalid data, please check and re-submit.'));
                return $this->renderForm($data);
            }
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
            // Set jump
            $url = array('action' => 'finish');
            $message = __('Your Contact send and saved successfully');
        } else {
            $url = array('action' => 'index');
            $message = __('Nothing to do');
        }
        $this->jump($url, $message);
    }

    public function finishAction()
    {
        // Get Module Config
        $homeConfig = Pi::service('registry')->config->read($this->params('module'), 'home');
        // Set view
        $this->view()->setTemplate('index_finish');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('message', __('Contact Us'));
        $this->view()->assign('homeConfig', $homeConfig);
    }
    
    public function ajaxAction() {
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Set return array
        $return = array();
        // Check post
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form = new ContactForm('contact', $this->params('module'));
            $form->setInputFilter(new ContactFilter($this->params('module')));
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
            Pi::config('adminmail', 'mail') => Pi::config('adminname', 'mail'),
            $values['department_email'] => $values['department_title'],
        );
        
        // Set template info
        $values['create'] = _date($values['create']);
        
        // Set template
        $data = Pi::service('mail')->template('contact', $values);
        
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

    protected function renderForm($data = null)
    {
        // Get Module Config
        $homeConfig = Pi::service('registry')->config->read($this->params('module'), 'home');
        // Set form department
        if ($this->params('department')) {
            $row = $this->getModel('department')->find($this->params('department'), 'slug');
            if (!$row instanceof RowGateway || !$row->status) {
                $data['department'] = $this->config('default_department');
				$title = __('Contact Us');
            } else {
                $row = $row->toArray();
                $data['department'] = $row['id'];
				$title = $row['title'];
            }
        } else {
            $data['department'] = $this->config('default_department');
        }
        // Set form
        $form = new ContactForm('contact', $this->params('module'));
        $form->setAttribute('action', $this->url('.department', array('action' => 'save')));
        $form->setData($data);
        // Set keywords
        $keywords = _strip($title);
        $keywords = strtolower(trim($keywords));
        $keywords = array_unique(array_filter(explode(' ', $keywords)));
        $keywords = implode(',', $keywords);
        // Set Description
        $description = _strip($title);
		$description = strtolower(trim($description));
        $description = preg_replace('/[\s]+/', ' ', $description);
        // Set view
        $this->view()->headTitle($title);
        $this->view()->headDescription($description, 'append');
        $this->view()->headKeywords($keywords, 'append');
        $this->view()->setTemplate('index_form');
        $this->view()->assign('title', $title);
        $this->view()->assign('form', $form);
        $this->view()->assign('homeConfig', $homeConfig);
    }

    protected function renderList()
    {
        // Get Module Config
        $homeConfig = Pi::service('registry')->config->read($this->params('module'), 'home');
        // get department list
        $select = $this->getModel('department')->select()->where(array('status' => 1))->order(array('id DESC'));
        $rowset = $this->getModel('department')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['url'] = $this->url('.department', array('module' => $this->params('module'), 'department' => $list[$row->id]['slug']));
        }
        // Set keywords
        $keywords = _strip(__('Select Department Form contact us'));
        $keywords = strtolower(trim($keywords));
        $keywords = array_unique(array_filter(explode(' ', $keywords)));
        $keywords = implode(',', $keywords);
        // Set Description
        $description = _strip(__('Select Department Form contact us'));
		$description = strtolower(trim($description));
        $description = preg_replace('/[\s]+/', ' ', $description);
        // Set view
        $this->view()->headTitle(__('Contact Us'));
        $this->view()->headDescription($description, 'append');
        $this->view()->headKeywords($keywords, 'append');
        $this->view()->setTemplate('index_list');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('message', __('Select Department Form contact us'));
        $this->view()->assign('lists', $list);
        $this->view()->assign('homeConfig', $homeConfig);
    }
}