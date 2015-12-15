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
    'admin' => array(
        'message' => array(
            'label'         => _a('Message'),
            'permission'    => array(
                'resource'  => 'message',
            ),
            'route'         => 'admin',
            'controller'    => 'message',
            'action'        => 'index',
        ),
        'department' => array(
            'label'         => _a('Department'),
            'permission'    => array(
                'resource'  => 'department',
            ),
            'route'         => 'admin',
            'controller'    => 'department',
            'action'        => 'index',
        ),
        'tools' => array(
            'label'         => _a('Tools'),
            'permission'    => array(
                'resource'  => 'tools',
            ),
            'route'         => 'admin',
            'controller'    => 'tools',
            'action'        => 'index',
        ),
        'json' => array(
            'label'         => _a('Json'),
            'permission'    => array(
                'resource'  => 'json',
            ),
            'route'         => 'admin',
            'controller'    => 'json',
            'action'        => 'index',
        ),
    ),
);