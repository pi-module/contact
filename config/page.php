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
    // Admin section
    'admin' => [
        [
            'title'      => _a('Message'),
            'controller' => 'message',
            'permission' => 'message',
        ],
        [
            'title'      => _a('Department'),
            'controller' => 'department',
            'permission' => 'department',
        ],
        [
            'title'      => _a('Tools'),
            'controller' => 'tools',
            'permission' => 'tools',
        ],
    ],
    // Front section
    'front' => [
        [
            'title'      => _a('Contact'),
            'controller' => 'index',
            'block'      => 1,
        ],
    ],
];