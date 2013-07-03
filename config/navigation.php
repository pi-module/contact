<?php
/**
 * Contact module config
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Hossein Azizabadi <azizabadi@faragostaresh.com>
 * @since           3.0
 * @package         Module\Contact
 * @version         $Id$
 */

return array(
    'admin' => array(
        'message' => array(
            'label' => __('Message'),
            'route' => 'admin',
            'controller' => 'message',
            'action' => 'index',
        ),
        'department' => array(
            'label' => __('Department'),
            'route' => 'admin',
            'controller' => 'department',
            'action' => 'index',
        ),
        'tools' => array(
            'label' => __('Tools'),
            'route' => 'admin',
            'controller' => 'tools',
            'action' => 'index',
        ),
    ),
);