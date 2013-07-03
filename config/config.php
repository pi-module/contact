<?php
/**
 * Contact module config
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

return array(
    'category' => array(
        array(
            'title' => __('Admin'),
            'name' => 'admin'
        ),
        array(
            'title' => __('HomePage'),
            'name' => 'home'
        ),
        array(
            'title' => __('Form'),
            'name' => 'form'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category' => 'admin',
            'title' => __('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 10
        ),
        // Home
        'homepage' => array(
            'title' => __('Homepage'),
            'description' => ' ',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'from' => __('Default form'),
                        'list' => __('List of Departments'),
                    ),
                ),
            ),
            'filter' => 'string',
            'value' => 'from',
            'category' => 'home',
        ),
        'toptext' => array(
            'title' => __('Top text'),
            'description' => '',
            'edit' => 'textarea',
            'value' => '',
            'category' => 'home',
        ),
        'bottomtext' => array(
            'title' => __('Bottom text'),
            'description' => '',
            'edit' => 'textarea',
            'value' => '',
            'category' => 'home',
        ),
        'sidetext' => array(
            'title' => __('Side text'),
            'description' => '',
            'edit' => 'textarea',
            'value' => '',
            'category' => 'home',
        ),
        'finishtext' => array(
            'title' => __('Finish text'),
            'description' => '',
            'edit' => 'textarea',
            'value' => '',
            'category' => 'home',
        ),
        // Form
        'default_department' => array(
            'title' => __('Default Department'),
            'description' => '',
            'value' => 1,
            'edit' => 'Module\Contact\Form\Element\Department',
            'filter' => 'number_int',
            'category' => 'form',
        ),
        'show_department' => array(
            'title' => __('show Department'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'show_organization' => array(
            'title' => __('show Organization'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'show_homepage' => array(
            'title' => __('show Homepage'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'show_location' => array(
            'title' => __('show Location'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'show_phone' => array(
            'title' => __('show Phone'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'show_address' => array(
            'title' => __('show Address'),
            'description' => '',
            'value' => 0,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
        'captcha' => array(
            'title' => __('Use captcha'),
            'description' => __('Captcha just use for gust'),
            'value' => 1,
            'filter' => 'number_int',
            'edit' => 'checkbox',
            'category' => 'form',
        ),
    ),
);