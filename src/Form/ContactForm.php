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
    public function __construct($name = null, $option = array())
    {
        $uid = Pi::user()->getId();
        $field = array(
            'id', 'identity', 'name', 'email'
        );
        $this->option = $option;
        $this->option['module'] = Pi::service('module')->current();
        $this->option['user'] = Pi::user()->get($uid, $field);

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
        $this->add(array(
            'name' => 'subject',
            'options' => array(
                'label' => __('Subject'),
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => true,
            )
        ));
        // department
        if ($this->option['config']['show_department']) {
            $this->add(array(
                'name' => 'department',
                'type' => 'Module\Contact\Form\Element\Department',
                'options' => array(
                    'label' => __('Department'),
                    'module' => $this->option['module'],
                ),
            ));
        } else {
            $this->add(array(
                'name' => 'department',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            ));
        }
        // Email
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => __('Email'),
            ),
            'attributes' => array(
                'type' => 'text',
                'value' => $this->option['user']['email'],
                'required' => true,
            )
        ));
        // Name
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => __('Name'),
            ),
            'attributes' => array(
                'type' => 'text',
                'value' => $this->option['user']['name'],
                'required' => true,
            )
        ));
        // Organization
        if ($this->option['config']['show_organization']) {
            $this->add(array(
                'name' => 'organization',
                'options' => array(
                    'label' => __('Organization'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $this->option['config']['required_organization'] ? true : false,
                )
            ));
        }
        // Homepage
        if ($this->option['config']['show_homepage']) {
            $this->add(array(
                'name' => 'homepage',
                'options' => array(
                    'label' => __('Homepage'),
                ),
                'attributes' => array(
                    'type' => 'url',
                    'required' => $this->option['config']['required_homepage'] ? true : false,
                )
            ));
        }
        // Location
        if ($this->option['config']['show_location']) {
            $this->add(array(
                'name' => 'location',
                'options' => array(
                    'label' => __('Location'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $this->option['config']['required_location'] ? true : false,
                )
            ));
        }
        // Phone
        if ($this->option['config']['show_phone']) {
            $this->add(array(
                'name' => 'phone',
                'options' => array(
                    'label' => __('Phone'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $this->option['config']['required_phone'] ? true : false,
                )
            ));
        }
        // Address
        if ($this->option['config']['show_address']) {
            $this->add(array(
                'name' => 'address',
                'options' => array(
                    'label' => __('Address'),
                ),
                'attributes' => array(
                    'required' => $this->option['config']['required_address'] ? true : false,
                    'type' => 'textarea',
                    'rows' => '2',
                    'cols' => '40',
                )
            ));
        }
        // Message		  
        $this->add(array(
            'name' => 'message',
            'options' => array(
                'label' => __('Message'),
            ),
            'attributes' => array(
                'required' => true,
                'type' => 'textarea',
                'rows' => '5',
                'cols' => '40',
            )
        ));
        // captcha
        if ($this->option['user']['id'] == 0 && $this->option['captcha'] == 1) {
            $captchaMode = $this->option['config']['captcha'];
            if($captchaElement = Pi::service('form')->getReCaptcha($captchaMode)){
                $this->add($captchaElement);
            }
        }
        // security
        /* $this->add(array(
            'name' => 'security',
            'type' => 'csrf',
        )); */

        // Save
        $this->add(array(
            'name' => 'submit-button',
            'type' => 'submit',
            'options'=> array(
                'label' => __('Submit'),

            ),
            'attributes' => array(
                'class' => 'btn btn-secondary'
            )
        ));
    }
}