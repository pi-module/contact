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
namespace Module\Contact\Api;

use Pi;
use Pi\Application\Api\AbstractApi;
use Module\Contact\Form\ContactForm;
use Module\Contact\Form\ContactFilter;

/*
 * Pi::api('api', 'contact')->send($values);
 * Pi::api('api', 'contact')->contact($data);
 */

class Api extends AbstractApi
{
    public function send($values)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Set values
        $values['uid'] = isset($values['uid']) ? $values['uid'] : Pi::user()->getId();
        $values['ip'] = Pi::user()->getIp();
        $values['time_create'] = time();
        $values['department'] = $config['default_department'];
        $values['name'] = _strip($values['name']);
        $values['subject'] = _strip($values['subject']);
        $values['message'] = _strip($values['message']);
        // Save
        $row = Pi::model('message', $this->getModule())->createRow();
        $row->assign($values);
        $row->save();
        // Set department
        $department = Pi::model('department', $this->getModule())->find($values['department'])->toArray();
        $values['department_title'] = $department['title'];
        $values['department_email'] = $department['email'];
        // Send as mail
        Pi::api('mail', 'contact')->toAdmin($values);
        Pi::api('mail', 'contact')->toUser($values);

        return true;
    }

    public function contact($data)
    {
        $result = array();

        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Set option
        $option = array(
            'captcha' => 0,
            'config' => $config,
        );
        // Set form
        $form = new ContactForm('contact', $option);
        $form->setInputFilter(new ContactFilter($option));
        $form->setData($data);
        if ($form->isValid()) {
            // Set values
            $values = $form->getData();
            // Save
            $this->send($values);
            // return
            $result['message'] = __('Your Contact send and saved successfully');
            $result['submit'] = 1;
            $result['status'] = 1;
        } else {
            $result['message'] = __('Send information not valid');
            $result['submit'] = 0;
            $result['status'] = 0;
        }

        return $result;
    }
}