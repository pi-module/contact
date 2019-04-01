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
return [
    'category' => [
        [
            'title' => _a('Admin'),
            'name'  => 'admin',
        ],
        [
            'title' => _a('HomePage'),
            'name'  => 'home',
        ],
        [
            'title' => _a('Form'),
            'name'  => 'form',
        ],
        [
            'title' => _a('Google Map'),
            'name'  => 'gmap',
        ],
    ],
    'item'     => [
        // Admin
        'admin_perpage'         => [
            'category'    => 'admin',
            'title'       => _a('Perpage'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 50,
        ],
        'sms_replay'            => [
            'category'    => 'admin',
            'title'       => _a('Reply by SMS'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
        ],
        // Home
        'breadcrumbs'           => [
            'title'       => _a('Show breadcrumbs'),
            'description' => '',
            'value'       => 1,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'home',
        ],
        'toptext'               => [
            'title'       => _a('Top text'),
            'description' => '',
            'edit'        => 'textarea',
            'value'       => '',
            'category'    => 'home',
        ],
        'bottomtext'            => [
            'title'       => _a('Bottom text'),
            'description' => '',
            'edit'        => 'textarea',
            'value'       => '',
            'category'    => 'home',
        ],
        'sidetext'              => [
            'title'       => _a('Side text'),
            'description' => '',
            'edit'        => 'textarea',
            'value'       => '',
            'category'    => 'home',
        ],
        'finishtext'            => [
            'title'       => _a('Finish text'),
            'description' => '',
            'edit'        => 'textarea',
            'value'       => _a('Message correctly Send, a confirmation has just been sent to you by email'),
            'category'    => 'home',
        ],
        // Form
        'default_department'    => [
            'title'       => _a('Default department'),
            'description' => '',
            'value'       => 1,
            'edit'        => 'Module\Contact\Form\Element\Department',
            'filter'      => 'number_int',
            'category'    => 'form',
        ],
        'show_title'            => [
            'title'       => _a('show title'),
            'description' => '',
            'value'       => 1,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_department'       => [
            'title'       => _a('show Department'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_organization'     => [
            'title'       => _a('show Organization'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'required_organization' => [
            'title'       => _a('required Organization'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_homepage'         => [
            'title'       => _a('show Homepage'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'required_homepage'     => [
            'title'       => _a('required Homepage'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_location'         => [
            'title'       => _a('show Location'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'required_location'     => [
            'title'       => _a('required Location'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_phone'            => [
            'title'       => _a('show Phone'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'required_phone'        => [
            'title'       => _a('required Phone'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'show_address'          => [
            'title'       => _a('show Address'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'required_address'      => [
            'title'       => _a('required Address'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'form',
        ],
        'captcha'               => [
            'title'       => _t('Use CAPTCHA'),
            'description' => _t('Captcha just use for guest'),
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        0 => _t('No captcha'),
                        1 => _t('Standard captcha'),
                        2 => _t('New re-captcha'),
                        3 => _t('Invisible captcha'),
                    ],
                ],
            ],
            'value'       => 0,
            'filter'      => 'int',
            'category'    => 'form',
        ],
        // Gmap
        'wide_content'          => [
            'category'    => 'gmap',
            'title'       => _a('Active wide front image for this module'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'gmap_show'             => [
            'title'       => _a('Show Google Map'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'gmap',
        ],
        'gmap_position'         => [
            'title'       => _a('Position'),
            'description' => ' ',
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'side' => _a('Side'),
                        'top'  => _a('Top'),
                    ],
                ],
            ],
            'filter'      => 'string',
            'value'       => 'side',
            'category'    => 'gmap',
        ],
        'gmap_latitude'         => [
            'title'       => _a('Latitude'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'gmap',
        ],
        'gmap_longitude'        => [
            'title'       => _a('Longitude'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'gmap',
        ],
        'gmap_zoon'             => [
            'title'       => _a('Zoon'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '16',
            'category'    => 'gmap',
        ],
        'gmap_title'            => [
            'title'       => _a('Title'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'gmap',
        ],
        'gmap_api_key'          => [
            'category'    => 'gmap',
            'title'       => _a('Set Google map API KEY'),
            'description' => _a(
                'For obtaining an API Key please read this document : https://developers.google.com/maps/documentation/javascript/tutorial#api_key'
            ),
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
        ],
        'gmap_type'             => [
            'title'       => _a('Map type'),
            'description' => '',
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'ROADMAP'   => _a('ROADMAP'),
                        'SATELLITE' => _a('SATELLITE'),
                        'HYBRID'    => _a('HYBRID'),
                        'TERRAIN'   => _a('TERRAIN'),
                    ],
                ],
            ],
            'filter'      => 'text',
            'value'       => 'ROADMAP',
            'category'    => 'gmap',
        ],
    ],
];