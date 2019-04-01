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

class ReplyForm extends BaseForm
{
    public function __construct($name = null, $option = [])
    {
        $this->option = $option;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new ReplyFilter($this->option);
        }
        return $this->filter;
    }

    public function init()
    {
        // Author
        $this->add(
            [
                'name'       => 'uid',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );
        // Message id
        $this->add(
            [
                'name'       => 'mid',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );
        // To Name
        $this->add(
            [
                'name'       => 'name',
                'options'    => [
                    'label' => __('To Name'),
                ],
                'attributes' => [
                    'type'  => 'text',
                    'label' => __('To Name'),
                ],
            ]
        );
        // Check
        if ($this->option['sms_replay']) {
            // mobile
            $this->add(
                [
                    'name'       => 'mobile',
                    'options'    => [
                        'label' => __('Mobile'),
                    ],
                    'attributes' => [
                        'type' => 'text',
                    ],
                ]
            );
        } else {
            // To Email
            $this->add(
                [
                    'name'       => 'email',
                    'options'    => [
                        'label' => __('To Email'),
                    ],
                    'attributes' => [
                        'type'  => 'text',
                        'label' => __('To Email'),
                    ],
                ]
            );
        }
        // To Subject
        $this->add(
            [
                'name'       => 'subject',
                'options'    => [
                    'label' => __('Subject'),
                ],
                'attributes' => [
                    'type'  => 'text',
                    'label' => __('Subject'),
                ],
            ]
        );
        // Message		  
        $this->add(
            [
                'name'       => 'message',
                'options'    => [
                    'label' => __('Message'),
                ],
                'attributes' => [
                    'type'  => 'textarea',
                    'value' => '',
                    'rows'  => '5',
                    'cols'  => '40',
                    'label' => __('Message'),
                ],
            ]
        );
        // Save
        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => __('Submit'),
                ],
            ]
        );
    }
}	   