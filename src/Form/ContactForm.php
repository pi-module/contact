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
namespace Module\Contact\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class ContactForm extends BaseForm
{
    public function __construct($name = null)
    {
        $this->module = Pi::service('module')->current();
        parent::__construct($name);
    }

    public function init()
    {
        // Get configs
        $config = Pi::service('registry')->config->read($this->module, 'form');

        // Get user
        $user = Pi::user()->bind();
        // User id
        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type' => 'hidden',
                'value' => $user->id,
            ),
        ));
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
        if ($config['show_department']) {
            $this->add(array(
                'name' => 'department',
                'type' => 'Module\Contact\Form\Element\Department',
                'options' => array(
                    'label' => __('Department'),
                    'module' => $this->module,
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
                'value' => $user->email,
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
                'value' => $user->identity,
                'required' => true,
            )
        ));
        // Organization
        if ($config['show_organization']) {
            $this->add(array(
                'name' => 'organization',
                'options' => array(
                    'label' => __('Organization'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $config['required_organization'] ? true : false,
                )
            ));
        }
        // Homepage
        if ($config['show_homepage']) {
            $this->add(array(
                'name' => 'homepage',
                'options' => array(
                    'label' => __('Homepage'),
                ),
                'attributes' => array(
                    'type' => 'url',
                    'required' => $config['required_homepage'] ? true : false,
                )
            ));
        }
        // Location
        if ($config['show_location']) {
            $this->add(array(
                'name' => 'location',
                'options' => array(
                    'label' => __('Location'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $config['required_location'] ? true : false,
                )
            ));
        }
        // Phone
        if ($config['show_phone']) {
            $this->add(array(
                'name' => 'phone',
                'options' => array(
                    'label' => __('Phone'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'required' => $config['required_phone'] ? true : false,
                )
            ));
        }
        // Address
        if ($config['show_address']) {
            $this->add(array(
                'name' => 'address',
                'options' => array(
                    'label' => __('Address'),
                ),
                'attributes' => array(
                    'required' => $config['required_address'] ? true : false,
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
        if ($user->id == 0) {
            $captchaMode = $config['captcha'];
            if($captchaElement = Pi::service('form')->getReCaptcha($captchaMode)){
                $this->add($captchaElement);
            }
        }

        // security
        $this->add(array(
            'name' => 'security',
            'type' => 'csrf',
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
            )
        ));
    }
}