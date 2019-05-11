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
    // Front section
    'front' => array(
        'public'         => array(
            'title'         => _a('Global public resource'),
            'access'        => array(
                'guest',
                'member',
            ),
        ),
    ),
    // Admin section
    'admin' => array(
        'message'       => array(
            'title'         => _a('Message'),
            'access'        => array(
                //'admin',
            ),
        ),
        'department'       => array(
            'title'         => _a('Department'),
            'access'        => array(
                //'admin',
            ),
        ),
        'tools'       => array(
            'title'         => _a('Tools'),
            'access'        => array(
                //'admin',
            ),
        ),
    ),
);