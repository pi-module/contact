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
        $adminmail = Pi::config('adminmail');
        $adminname = Pi::config('adminname');

        // Set to
        $to = [
            $values['department_email'] => $values['department_title'],
        ];

        // Set to admin
        if (!empty($adminmail) && $adminmail != $values['department_email']) {
            $to = [
                $values['department_email'] => $values['department_title'],
                $adminmail                  => $adminname,
            ];
        }

        // Set template info
        $values['time_create'] = _date($values['time_create']);

        // Send mail
        $this->send($to, $values, 'contact');
    }

    public function toUser($values)
    {
        // Set to
        $to = [
            $values['email'] => $values['name'],
        ];

        // Set template info
        $values['time_create'] = _date($values['time_create']);

        // Send mail
        $this->send($to, $values, 'user');
    }

    public function toReply($values)
    {
        // Set to
        $to = [
            $values['email'] => $values['name'],
        ];

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
        /** @var \Laminas\Mail\Message $message */
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");

        if (!empty($values['email'])) {
            $message->setFrom($values['email']);
            $message->setReplyTo($values['email']);
            $message->setSender($values['email']);
        }

        // Send mail
        Pi::service('mail')->send($message);
    }
}
