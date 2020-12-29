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
            'title' => _a('Security'),
            'name'  => 'security',
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
            'title' => _a('File'),
            'name'  => 'file',
        ],
        [
            'title' => _a('Map'),
            'name'  => 'map',
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

        // Security
        'block_time'            => [
            'category'    => 'security',
            'title'       => _a('Next submit block time'),
            'description' => _a('Set block time for next submit form by min,'),
            'value'       => 60,
            'filter'      => 'number_int',
            'edit'        => 'text',
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
        'show_attachment'          => [
            'title'       => _a('show attachment'),
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

        // File
        'file_size'                 => [
            'category'    => 'file',
            'title'       => _a('File Size'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 1000000,
        ],
        'file_extension'            => [
            'category'    => 'file',
            'title'       => _a('File Extension'),
            'description' => '',
            'edit'        => 'textarea',
            'filter'      => 'string',
            'value'       => 'jpg,jpeg,png,gif,avi,flv,mp3,mp4,pdf,docs,xdocs,zip,rar',
        ],

        // Map
        'wide_content'          => [
            'category'    => 'map',
            'title'       => _a('Active wide front map for this module'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'map_show'              => [
            'title'       => _a('Show Map on contact page'),
            'description' => '',
            'value'       => 0,
            'filter'      => 'number_int',
            'edit'        => 'checkbox',
            'category'    => 'map',
        ],
        'map_position'          => [
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
            'category'    => 'map',
        ],
        'map_latitude'          => [
            'title'       => _a('Latitude'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'map',
        ],
        'map_longitude'         => [
            'title'       => _a('Longitude'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'map',
        ],
        'map_zoom'              => [
            'title'       => _a('Zoom'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 15,
            'category'    => 'map',
        ],
        'map_title'             => [
            'title'       => _a('Title'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
            'value'       => '',
            'category'    => 'map',
        ],
        'map_type'              => [
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
            'category'    => 'map',
        ],
    ],
];
