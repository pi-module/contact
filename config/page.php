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
        array(
            'title'         => _a('Json'),
            'controller'    => 'json',
            'permission'    => 'json',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'title'         => _a('Contact'),
            'controller'    => 'index',
            'permission'    => 'public',
            'block'         => 1,
        ),
    ),
);