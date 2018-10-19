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
return array(
    // Admin section
    'admin' => array(
        array(
            'title'         => _a('Message'),
            'controller'    => 'message',
            'permission'    => 'message',
        ),
        array(
            'title'         => _a('Department'),
            'controller'    => 'department',
            'permission'    => 'department',
        ),
        array(
            'title'         => _a('Tools'),
            'controller'    => 'tools',
            'permission'    => 'tools',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'title'         => _a('Contact'),
            'controller'    => 'index',
            'block'         => 1,
        ),
    ),
);