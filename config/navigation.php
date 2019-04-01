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
    'admin' => [
        'message'    => [
            'label'      => _a('Message'),
            'permission' => [
                'resource' => 'message',
            ],
            'route'      => 'admin',
            'controller' => 'message',
            'action'     => 'index',
        ],
        'department' => [
            'label'      => _a('Department'),
            'permission' => [
                'resource' => 'department',
            ],
            'route'      => 'admin',
            'controller' => 'department',
            'action'     => 'index',
            'pages'      => [
                'department' => [
                    'label'      => _a('Department'),
                    'permission' => [
                        'resource' => 'department',
                    ],
                    'route'      => 'admin',
                    'controller' => 'department',
                    'action'     => 'index',
                ],
                'update'     => [
                    'label'      => _a('Manage department'),
                    'permission' => [
                        'resource' => 'department',
                    ],
                    'route'      => 'admin',
                    'controller' => 'department',
                    'action'     => 'update',
                ],
            ],
        ],
        'tools'      => [
            'label'      => _a('Tools'),
            'permission' => [
                'resource' => 'tools',
            ],
            'route'      => 'admin',
            'controller' => 'tools',
            'action'     => 'setting',
            'pages'      => [
                'setting' => [
                    'label'      => _a('Setting'),
                    'permission' => [
                        'resource' => 'tools',
                    ],
                    'route'      => 'admin',
                    'controller' => 'tools',
                    'action'     => 'setting',
                ],
                'prune'   => [
                    'label'      => _a('Prune'),
                    'permission' => [
                        'resource' => 'tools',
                    ],
                    'route'      => 'admin',
                    'controller' => 'tools',
                    'action'     => 'prune',
                ],
                'json'    => [
                    'label'      => _a('Json'),
                    'permission' => [
                        'resource' => 'tools',
                    ],
                    'route'      => 'admin',
                    'controller' => 'tools',
                    'action'     => 'json',
                ],
            ],
        ],
    ],
];