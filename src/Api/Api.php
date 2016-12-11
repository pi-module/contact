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
 * Pi::api('api', 'contact')->send($values);
 */

class Api extends AbstractApi
{
    public function send($values)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Set values
        $values['uid'] = Pi::user()->getId();
        $values['ip'] = Pi::user()->getIp();
        $values['time_create'] = time();
        $values['department'] = $config['default_department'];
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
    }
}