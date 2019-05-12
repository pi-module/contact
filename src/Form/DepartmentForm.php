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

class DepartmentForm extends BaseForm
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new DepartmentFilter;
        }
        return $this->filter;
    }

    public function init()
    {
        // Id
        $this->add(
            [
                'name'       => 'id',
                'attributes' => [
                    'type' => 'hidden',
                ],
            ]
        );
        // Title
        $this->add(
            [
                'name'       => 'title',
                'options'    => [
                    'label' => __('Title'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'label'    => __('Title'),
                    'required' => true,
                ],
            ]
        );
        // slug
        $this->add(
            [
                'name'       => 'slug',
                'options'    => [
                    'label' => __('Slug'),
                ],
                'attributes' => [
                    'type' => 'text',
                ],
            ]
        );
        // Email
        $this->add(
            [
                'name'       => 'email',
                'options'    => [
                    'label' => __('Email'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'label'    => __('Email'),
                    'required' => true,
                ],
            ]
        );
        // status
        $this->add(
            [
                'name'       => 'status',
                'type'       => 'select',
                'options'    => [
                    'label'         => __('Status'),
                    'value_options' => [
                        1 => __('Published'),
                        2 => __('Pending review'),
                        3 => __('Draft'),
                        4 => __('Private'),
                        5 => __('Expired'),
                    ],
                ],
                'attributes' => [
                    'required' => true,
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