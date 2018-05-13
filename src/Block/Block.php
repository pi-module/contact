<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Contact\Block;

use Pi;
use Module\Contact\Form\ContactForm;

class Block
{
    public static function contact($options = array(), $module = null)
    {
        // Load language
        Pi::service('i18n')->load(array('module/contact', 'default'));

        // Set options
        $block = array();
        $block = array_merge($block, $options);

        // Get config
        $config = Pi::service('registry')->config->read($module);

        // Set data
        $data = array(
            'department' => $config['default_department'],
        );

        // Set option
        $option = array(
            'captcha' => 1,
            'config' => $config,
        );

        // Set form
        $form = new ContactForm('subscription', $option);
        $form->setAttribute('enctype', 'multipart/form-data');
        $form->setAttribute('action', Pi::url(Pi::service('url')->assemble('default', array(
            'module' => $module,
        ))));
        $form->setData($data);
        $block['form'] = $form;

        return $block;
    }
}