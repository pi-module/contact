<?php
/**
 * Contact form
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Hossein Azizabadi <azizabadi@faragostaresh.com>
 * @since           3.0
 * @package         Module\Contact
 * @version         $Id$
 */

namespace Module\Contact\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class ContactForm extends BaseForm
{
    protected $classname = 'span12';

    public function __construct($name = null, $module)
    {
        $this->module = $module;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new ContactFilter($this->module);
        }
        return $this->filter;
    }

    public function init()
    {
        // Get configs
        $config = Pi::service('registry')->config->read($this->module, 'form');
        // User id
        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type' => 'hidden',
                'value' => Pi::registry('user')->id,
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
                'class' => $this->classname,
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
                'attributes' => array(
                    'class' => $this->classname,
                )
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
                'value' => Pi::registry('user')->email,
                'class' => $this->classname,
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
                'value' => Pi::registry('user')->identity,
                'class' => $this->classname,
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
                    'class' => $this->classname,
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
                    'class' => $this->classname,
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
                    'class' => $this->classname,
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
                    'class' => $this->classname,
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
                    'type' => 'textarea',
                    'rows' => '2',
                    'cols' => '40',
                    'class' => $this->classname,
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
                'type' => 'textarea',
                'rows' => '5',
                'cols' => '40',
                'class' => $this->classname,
            )
        ));
        // captcha
        if ($config['captcha'] && (Pi::registry('user')->id == 0)) {
            $this->add(array(
                'name' => 'captcha',
                'type' => 'captcha',
                'options' => array(
                    'label' => __('Please type the word.'),
                )
            ));
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