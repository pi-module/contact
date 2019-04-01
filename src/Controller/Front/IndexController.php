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

namespace Module\Contact\Controller\Front;

use Module\Contact\Form\ContactFilter;
use Module\Contact\Form\ContactForm;
use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Set info
        $module = $this->params('module');

        // Get config
        $config = Pi::service('registry')->config->read($module);

        // Check session
        if (isset($_SESSION['CONTACT'])) {

        }

        // Set option
        $option = [
            'captcha' => 1,
            'config'  => $config,
        ];

        // Set form
        $form = new ContactForm('contact', $option);

        // Get post
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new ContactFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                // Set values
                $values['uid']         = Pi::user()->getId();
                $values['ip']          = Pi::user()->getIp();
                $values['time_create'] = time();
                $values['name']        = _strip($values['name']);
                $values['subject']     = _strip($values['subject']);
                $values['message']     = _strip($values['message']);

                // Save
                $row = $this->getModel('message')->createRow();
                $row->assign($values);
                $row->save();

                // Set session
                $_SESSION['CONTACT'] = [
                    'submit_time' => $values['time_create'],
                    'submit_ip'   => $values['ip'],
                ];

                // Get department
                $department = $this->getModel('department')->find($values['department'])->toArray();

                // Set department
                $values['department_title'] = $department['title'];
                $values['department_email'] = $department['email'];

                // Send as mail
                Pi::api('mail', 'contact')->toAdmin($values);
                Pi::api('mail', 'contact')->toUser($values);

                // Set finish
                $message = __('Message correctly Send, a confirmation has just been sent to you by email');
                $message = (!empty($config['finishtext'])) ? $config['finishtext'] : $message;

                // Set

                // Jump
                $this->jump(['action' => 'index'], $message);
            }
        } else {
            // Set data
            $data = [
                'department' => $config['default_department'],
            ];

            // Get user information
            if (Pi::service('authentication')->hasIdentity()) {
                $user          = Pi::user()->get(Pi::user()->getId(), ['id', 'name', 'email']);
                $data['name']  = $user['name'];
                $data['email'] = $user['email'];
            }

            // Set data
            $form->setData($data);
        }

        // Set view
        $this->view()->setTemplate('contact-form');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('form', $form);
        $this->view()->assign('config', $config);
    }
}