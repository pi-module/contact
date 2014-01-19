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
            'controller'    => 'message',
            'permission'    => 'message',
        ),
        array(
            'controller'    => 'department',
            'permission'    => 'department',
        ),
        array(
            'controller'    => 'tools',
            'permission'    => 'tools',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'controller'    => 'index',
            'permission'    => 'index',
            'block'         => 1,
        ),
    ),
);