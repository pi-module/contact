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
    // Front section
    'front' => array(
        'public'    => array(
            'title'         => _t('Global public resource'),
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