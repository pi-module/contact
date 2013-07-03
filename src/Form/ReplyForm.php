<?php
/**
 * Reply form
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

class ReplyForm extends BaseForm
{
    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new ReplyFilter;
        }
        return $this->filter;
    }

    public function init()
    {
        // Author
        $this->add(array(
            'name' => 'author',
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