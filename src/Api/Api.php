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

namespace Module\Contact\Api;

use Module\Contact\Form\ContactFilter;
use Module\Contact\Form\ContactForm;
use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('api', 'contact')->send($values);
 * Pi::api('api', 'contact')->contact($data);
 * Pi::api('api', 'contact')->rename($fileName);
 */

class Api extends AbstractApi
{
    public function send($values)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Set values
        $values['uid']         = isset($values['uid']) ? $values['uid'] : Pi::user()->getId();
        $values['ip']          = Pi::user()->getIp();
        $values['time_create'] = time();
        $values['department']  = $config['default_department'];
        $values['name']        = _strip($values['name']);
        $values['subject']     = _strip($values['subject']);
        $values['message']     = _strip($values['message']);

        // Save
        $row = Pi::model('message', $this->getModule())->createRow();
        $row->assign($values);
        $row->save();

        // Set department
        $department                 = Pi::model('department', $this->getModule())->find($values['department'])->toArray();
        $values['department_title'] = $department['title'];
        $values['department_email'] = $department['email'];

        // Send as mail
        Pi::api('mail', 'contact')->toAdmin($values);
        Pi::api('mail', 'contact')->toUser($values);

        return true;
    }

    public function contact($data)
    {
        $result = [];

        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Set option
        $option = [
            'captcha' => 0,
            'config'  => $config,
        ];

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
            $result['submit']  = 1;
            $result['status']  = 1;
        } else {
            $result['message'] = __('Send information not valid');
            $result['submit']  = 0;
            $result['status']  = 0;
        }

        return $result;
    }

    public function rename($fileName)
    {
        // Separating image name and extension
        $name      = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        // strip name
        $name = _strip($name);
        $name = strtolower(trim($name));
        $name = preg_replace("/[^a-zA-Z0-9 ]+/", "", $name);
        $name = array_filter(explode(' ', $name));
        $name = implode('-', $name) . '.' . $extension;

        // Check text length
        if (mb_strlen($name, 'UTF-8') < 8) {
            $name = '%random%';
        }

        // return
        return $name;
    }
}
