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
    // Front section
    'front' => [
        'public' => [
            'title'  => _a('Global public resource'),
            'access' => [
                'guest',
                'member',
            ],
        ],
    ],
    // Admin section
    'admin' => [
        'message'    => [
            'title'  => _a('Message'),
            'access' => [
                //'admin',
            ],
        ],
        'department' => [
            'title'  => _a('Department'),
            'access' => [
                //'admin',
            ],
        ],
        'tools'      => [
            'title'  => _a('Tools'),
            'access' => [
                //'admin',
            ],
        ],
    ],
];