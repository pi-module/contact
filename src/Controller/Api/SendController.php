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

namespace Module\Contact\Controller\Api;

use Pi;
use Pi\Mvc\Controller\ApiController;
use Module\System\Validator\UserEmail as UserEmailValidator;

class SendController extends ApiController
{
    public function indexAction()
    {
        // Set default result
        $result = [
            'result' => false,
            'data'   => [],
            'error'  => [
                'code'    => 1,
                'message' => __('Nothing selected'),
            ],
        ];

        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');

        // Check token
        $check = Pi::api('token', 'tools')->check($token);
        if ($check['status'] == 1) {

            // Get config
            $config = Pi::service('registry')->config->read($module);

            // Save statistics
            if (Pi::service('module')->isActive('statistics')) {
                Pi::api('log', 'statistics')->save(
                    'contact', 'send', 0, [
                        'source'  => $this->params('platform'),
                        'section' => 'api',
                    ]
                );
            }

            // Get info from url
            $name         = $this->params('name');
            $subject      = $this->params('subject');
            $message      = $this->params('message');
            $email        = $this->params('email');
            $organization = $this->params('organization');
            $department   = $this->params('department', $config['default_department']);
            $homepage     = $this->params('homepage');
            $location     = $this->params('location');
            $phone        = $this->params('phone');
            $address      = $this->params('address');

            // Check valid
            $emailValidator = new UserEmailValidator(
                [
                    'blacklist'         => false,
                    'check_duplication' => false,
                ]
            );
            if (!$emailValidator->isValid($email)) {
                $messages = $emailValidator->getMessages();

                // Set error
                $result['error']['message'] = $messages;

                // return
                return $result;
            }

            // Check empty
            if (empty($name) || empty($subject) || empty($message)) {
                // Set error
                $result['error']['message'] = __('Required data are empty !');
                // return
                return $result;
            }

            // Set values
            $values                 = [];
            $values['uid']          = Pi::user()->getId();
            $values['ip']           = Pi::user()->getIp();
            $values['time_create']  = time();
            $values['department']   = intval($department);
            $values['email']        = $email;
            $values['name']         = _strip($name);
            $values['subject']      = _strip($subject);
            $values['message']      = _strip($message);
            $values['organization'] = _strip($organization);
            $values['homepage']     = _strip($homepage);
            $values['location']     = _strip($location);
            $values['phone']        = _strip($phone);
            $values['address']      = _strip($address);

            // Save
            $row = $this->getModel('message')->createRow();
            $row->assign($values);
            $row->save();

            // Get department
            $department = $this->getModel('department')->find($values['department'])->toArray();

            // Set department
            $values['department_title'] = $department['title'];
            $values['department_email'] = $department['email'];

            // Send as mail
            Pi::api('mail', 'contact')->toAdmin($values);
            Pi::api('mail', 'contact')->toUser($values);

            // Set message
            $message = __('Message correctly Send, a confirmation has just been sent to you by email');
            $message = (!empty($config['finishtext'])) ? $config['finishtext'] : $message;

            // Set default result
            $result = [
                'result' => true,
                'data'   => [
                    'message' => $message,
                ],
                'error'  => [],
            ];

        } else {
            // Set error
            $result['error'] = [
                'code'    => 2,
                'message' => $check['message'],
            ];
        }

        // Return result
        return $result;
    }
}