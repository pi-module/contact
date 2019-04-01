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

namespace Module\Contact\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class ContactForm extends BaseForm
{
    public function __construct($name = null, $option = [])
    {
        $uid                    = Pi::user()->getId();
        $field                  = [
            'id', 'identity', 'name', 'email',
        ];
        $this->option           = $option;
        $this->option['module'] = Pi::service('module')->current();
        $this->option['user']   = Pi::user()->get($uid, $field);

        /**
         * SetInputFilter here, for keeping auto-injected captcha validator
         */
        $this->setInputFilter(new ContactFilter($this->option));

        parent::__construct($name);

    }

    public function init()
    {
        // User id
        /* $this->add(array(
            'name' => 'uid',
            'attributes' => array(
                'type' => 'hidden',
                'value' => $this->option['user']['id'],
            ),
        )); */
        // Subject
        $this->add(
            [
                'name'       => 'subject',
                'options'    => [
                    'label' => __('Subject'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'required' => true,
                ],
            ]
        );
        // department
        if ($this->option['config']['show_department']) {
            $this->add(
                [
                    'name'    => 'department',
                    'type'    => 'Module\Contact\Form\Element\Department',
                    'options' => [
                        'label'  => __('Department'),
                        'module' => $this->option['module'],
                    ],
                ]
            );
        } else {
            $this->add(
                [
                    'name'       => 'department',
                    'attributes' => [
                        'type' => 'hidden',
                    ],
                ]
            );
        }
        // Email
        $this->add(
            [
                'name'       => 'email',
                'options'    => [
                    'label' => __('Email'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'value'    => $this->option['user']['email'],
                    'required' => true,
                ],
            ]
        );
        // Name
        $this->add(
            [
                'name'       => 'name',
                'options'    => [
                    'label' => __('Name'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'value'    => $this->option['user']['name'],
                    'required' => true,
                ],
            ]
        );
        // Organization
        if ($this->option['config']['show_organization']) {
            $this->add(
                [
                    'name'       => 'organization',
                    'options'    => [
                        'label' => __('Organization'),
                    ],
                    'attributes' => [
                        'type'     => 'text',
                        'required' => $this->option['config']['required_organization'] ? true : false,
                    ],
                ]
            );
        }
        // Homepage
        if ($this->option['config']['show_homepage']) {
            $this->add(
                [
                    'name'       => 'homepage',
                    'options'    => [
                        'label' => __('Homepage'),
                    ],
                    'attributes' => [
                        'type'     => 'url',
                        'required' => $this->option['config']['required_homepage'] ? true : false,
                    ],
                ]
            );
        }
        // Location
        if ($this->option['config']['show_location']) {
            $this->add(
                [
                    'name'       => 'location',
                    'options'    => [
                        'label' => __('Location'),
                    ],
                    'attributes' => [
                        'type'     => 'text',
                        'required' => $this->option['config']['required_location'] ? true : false,
                    ],
                ]
            );
        }
        // Phone
        if ($this->option['config']['show_phone']) {
            $this->add(
                [
                    'name'       => 'phone',
                    'options'    => [
                        'label' => __('Phone'),
                    ],
                    'attributes' => [
                        'type'     => 'text',
                        'required' => $this->option['config']['required_phone'] ? true : false,
                    ],
                ]
            );
        }
        // Address
        if ($this->option['config']['show_address']) {
            $this->add(
                [
                    'name'       => 'address',
                    'options'    => [
                        'label' => __('Address'),
                    ],
                    'attributes' => [
                        'required' => $this->option['config']['required_address'] ? true : false,
                        'type'     => 'textarea',
                        'rows'     => '2',
                        'cols'     => '40',
                    ],
                ]
            );
        }
        // Message		  
        $this->add(
            [
                'name'       => 'message',
                'options'    => [
                    'label' => __('Message'),
                ],
                'attributes' => [
                    'required' => true,
                    'type'     => 'textarea',
                    'rows'     => '5',
                    'cols'     => '40',
                ],
            ]
        );
        // captcha
        if ($this->option['user']['id'] == 0 && $this->option['captcha'] == 1) {
            $captchaMode = $this->option['config']['captcha'];
            if ($captchaElement = Pi::service('form')->getReCaptcha($captchaMode)) {
                $this->add($captchaElement);
            }
        }
        // security
        /* $this->add(array(
            'name' => 'security',
            'type' => 'csrf',
        )); */

        // Save
        $this->add(
            [
                'name'       => 'submit-button',
                'type'       => 'submit',
                'options'    => [
                    'label' => __('Submit'),

                ],
                'attributes' => [
                    'class' => 'btn btn-default',
                ],
            ]
        );
    }
}