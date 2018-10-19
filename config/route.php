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
    // route name
    'department' => array(
        'name'     => 'contact',
        'type'     => 'Module\Contact\Route\Department',
        'options'  => array(
            'route'     => '/contact',
            'defaults'  => array(
                'module'     => 'contact',
                'controller'  => 'index',
                'action'      => 'index'
            )
        ),
    )
);