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
    public function __construct($name = null, $option = array())
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
        $this->add(array(
            'name' => 'uid',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // Message id
        $this->add(array(
            'name' => 'mid',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // To Name
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => __('To Name'),
            ),
            'attributes' => array(
                'type' => 'text',
                'label' => __('To Name'),
            )
        ));
        // Check
        if ($this->option['sms_replay']) {
            // mobile
            $this->add(array(
                'name' => 'mobile',
                'options' => array(
                    'label' => __('Mobile'),
                ),
                'attributes' => array(
                    'type' => 'text',
                )
            ));
        } else {
            // To Email
            $this->add(array(
                'name' => 'email',
                'options' => array(
                    'label' => __('To Email'),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'label' => __('To Email'),
                )
            ));
        }
        // To Subject
        $this->add(array(
            'name' => 'subject',
            'options' => array(
                'label' => __('Subject'),
            ),
            'attributes' => array(
                'type' => 'text',
                'label' => __('Subject'),
            )
        ));
        // Message		  
        $this->add(array(
            'name' => 'message',
            'options' => array(
                'label' => __('Message'),
            ),
            'attributes' => array(
                'type' => 'textarea',
                'value' => '',
                'rows' => '5',
                'cols' => '40',
                'label' => __('Message'),
            )
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