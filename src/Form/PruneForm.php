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

class PruneForm extends BaseForm
{
    protected $options;

    public function __construct($name = null, $options = [])
    {
        $this->options = $options;
        parent::__construct($name);
    }

    public function init()
    {
        // date
        $this->add(
            [
                'name'       => 'date',
                'options'    => [
                    'label' => __('All contacts Before'),
                ],
                'attributes' => [
                    'type'     => 'text',
                    'value'    => date('Y-m-d'),
                    'label'    => __('All contacts Before'),
                    'required' => true,
                ],
            ]
        );
        // answer
        $this->add(
            [
                'name'       => 'answer',
                'type'       => 'checkbox',
                'options'    => [
                    'label' => __('Only remove Admin answers'),
                ],
                'attributes' => [
                    'value' => 0,
                    'label' => __('Only remove Admin answers'),
                ],
            ]
        );
        // department
        $this->add(
            [
                'name'       => 'department',
                'type'       => 'select',
                'options'    => [
                    'label'         => __('Department'),
                    'value_options' => $this->options,
                ],
                'attributes' => [
                    'description' => '',
                    'size'        => 5,
                    'multiple'    => 1,
                    'required'    => true,
                ],
            ]
        );
        // Submit
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