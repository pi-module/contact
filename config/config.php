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
return array(
    'category' => array(
        array(
            'title'  => _a('Admin'),
            'name'   => 'admin'
        ),
        /* array(
            'title' => _a('Mobile device'),
            'name' => 'json'
        ), */
        array(
            'title'  => _a('HomePage'),
            'name'   => 'home'
        ),
        array(
            'title'  => _a('Form'),
            'name'   => 'form'
        ),
        array(
            'title'  => _a('Google Map'),
            'name'   => 'gmap'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category'     => 'admin',
            'title'        => _a('Perpage'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 50
        ),
        // Json
        /* 'json_check_password' => array(
            'category' => 'json',
            'title' => _a('Check password for mobile device'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'json_password' => array(
            'category' => 'json',
            'title' => _a('Password for mobile device'),
            'description' => _a('After use on mobile device , do not change it'),
            'edit' => 'text',
            'filter' => 'string',
            'value' => md5(rand(1,99999)),
        ), */
        // Home
        'breadcrumbs' => array(
            'title'        => _a('Show breadcrumbs'),
            'description'  => '',
            'value'        => 1,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'home',
        ),
        'toptext' => array(
            'title'        => _a('Top text'),
            'description'  => '',
            'edit'         => 'textarea',
            'value'        => '',
            'category'     => 'home',
        ),
        'bottomtext' => array(
            'title'        => _a('Bottom text'),
            'description'  => '',
            'edit'         => 'textarea',
            'value'        => '',
            'category'     => 'home',
        ),
        'sidetext' => array(
            'title'        => _a('Side text'),
            'description'  => '',
            'edit'         => 'textarea',
            'value'        => '',
            'category'     => 'home',
        ),
        'finishtext' => array(
            'title'        => _a('Finish text'),
            'description'  => '',
            'edit'         => 'textarea',
            'value'        => _a('Message correctly Send, a confirmation has just been sent to you by email'),
            'category'     => 'home',
        ),
        // Form
        'default_department' => array(
            'title'        => _a('Default department'),
            'description'  => '',
            'value'        => 1,
            'edit'         => 'Module\Contact\Form\Element\Department',
            'filter'       => 'number_int',
            'category'     => 'form',
        ),
        'show_title' => array(
            'title'        => _a('show title'),
            'description'  => '',
            'value'        => 1,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_department' => array(
            'title'        => _a('show Department'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_organization' => array(
            'title'        => _a('show Organization'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'required_organization' => array(
            'title'        => _a('required Organization'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_homepage' => array(
            'title'        => _a('show Homepage'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'required_homepage' => array(
            'title'        => _a('required Homepage'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_location' => array(
            'title'        => _a('show Location'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'required_location' => array(
            'title'        => _a('required Location'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_phone' => array(
            'title'        => _a('show Phone'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'required_phone' => array(
            'title'        => _a('required Phone'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'show_address' => array(
            'title'        => _a('show Address'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'required_address' => array(
            'title'        => _a('required Address'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'form',
        ),
        'captcha'  => array(
            'title'         => _t('Use CAPTCHA'),
            'description'   => _t('Captcha just use for guest'),
            'edit'          => array(
                'type'      => 'select',
                'options'   => array(
                    'options'       => array(
                        0       => _t('No captcha'),
                        1       => _t('Standard captcha'),
                        2       => _t('New re-captcha'),
                    ),
                ),
            ),
            'value'         => 0,
            'filter'        => 'int',
            'category'      => 'form',
        ),
        // Gmap
        'wide_content' => array(
            'category' => 'gmap',
            'title' => _a('Active wide front image for this module'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
        'gmap_show' => array(
            'title'        => _a('Show Google Map'),
            'description'  => '',
            'value'        => 0,
            'filter'       => 'number_int',
            'edit'         => 'checkbox',
            'category'     => 'gmap',
        ),
        'gmap_position' => array(
            'title'        => _a('Position'),
            'description'  => ' ',
            'edit'         => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'side' => _a('Side'),
                        'top' => _a('Top'),
                    ),
                ),
            ),
            'filter'       => 'string',
            'value'        => 'side',
            'category'     => 'gmap',
        ),
        'gmap_latitude' => array(
            'title'        => _a('Latitude'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => '',
            'category'     => 'gmap',
        ),
        'gmap_longitude' => array(
            'title'        => _a('Longitude'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => '',
            'category'     => 'gmap',
        ),
        'gmap_zoon' => array(
            'title'        => _a('Zoon'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => '16',
            'category'     => 'gmap',
        ),
        'gmap_title' => array(
            'title'        => _a('Title'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => '',
            'category'     => 'gmap',
        ),
        'gmap_api_key' => array(
            'category' => 'gmap',
            'title' => _a('Set Google map API KEY'),
            'description' => _a('For obtaining an API Key please read this document : https://developers.google.com/maps/documentation/javascript/tutorial#api_key'),
            'edit' => 'text',
            'filter' => 'string',
            'value' => ''
        ),
        'gmap_type' => array(
            'title' => _a('Map type'),
            'description' => '',
            'edit' => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'ROADMAP' => _a('ROADMAP'),
                        'SATELLITE' => _a('SATELLITE'),
                        'HYBRID' => _a('HYBRID'),
                        'TERRAIN' => _a('TERRAIN'),
                    ),
                ),
            ),
            'filter' => 'text',
            'value' => 'ROADMAP',
            'category' => 'gmap',
        ),
    ),
);