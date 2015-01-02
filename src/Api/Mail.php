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

/*
 * Pi::api('mail', 'contact')->toAdmin($values);
 * Pi::api('mail', 'contact')->toUser($values);
 * Pi::api('mail', 'contact')->toReply($values);
 */

class Mail extends AbstractApi
{
	public function toAdmin($values)
    {
        // Get admin main
        $adminmail = Pi::config('adminmail', 'mail');
        // Set to
        $to = array(
            $values['department_email']  => $values['department_title'],
        );
        // Set to admin
        if ($adminmail != $values['department_email']) {
            $toAdmin = array(
                $adminmail                   => $values['department_title'],
            );
            $to = array_merge($to, $adminmail);
        }
        // Set template info
        $values['time_create'] = _date($values['time_create']);
        // Send mail
        $this->send($to, $values, 'contact');
    }

    public function toUser($values)
    {
        // Set to
        $to = array(
            $values['email'] => $values['name'],
        );
        // Set template info
        $values['time_create'] = _date($values['time_create']);
        // Send mail
        $this->send($to, $values, 'user');
    }

    public function toReply($values)
    {
        // Set to
        $to = array(
            $values['email'] => $values['name'],
        );
        // Set template info
        $values['time_create'] = _date($values['time_create']);
        // Send mail
        $this->send($to, $values, 'reply');
    }

    public function send($to, $values, $file)
    {
        // Set template
        $data = Pi::service('mail')->template($file, $values);
        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        // Send mail
        Pi::service('mail')->send($message);
    }
}