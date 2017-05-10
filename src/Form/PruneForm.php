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

class PruneForm extends BaseForm
{
    protected $options;

    public function __construct($name = null, $options = array())
    {
        $this->options = $options;
        parent::__construct($name);
    }

    public function init()
    {
        // date
        $this->add(array(
            'name' => 'date',
            'options' => array(
                'label' => __('All contacts Before'),
            ),
            'attributes' => array(
                'type' => 'text',
                'value' => date('Y-m-d'),
                'label' => __('All contacts Before'),
                'required' => true,
            )
        ));
        // answer
        $this->add(array(
            'name' => 'answer',
            'type' => 'checkbox',
            'options' => array(
                'label' => __('Only remove Admin answers'),
            ),
            'attributes' => array(
                'value' => 0,
                'label' => __('Only remove Admin answers'),
            )
        ));
        // department
        $this->add(array(
            'name' => 'department',
            'type' => 'select',
            'options' => array(
                'label' => __('Department'),
                'value_options' => $this->options,
            ),
            'attributes' => array(
                'description' => '',
                'size' => 5,
                'multiple' => 1,
                'required' => true,
            ),
        ));
        // Submit
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
            )
        ));
    }
}	