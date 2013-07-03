<?php
/**
 * Pi module installer action
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
 * @subpackage      Installer
 * @version         $Id$
 */

namespace Module\Contact\Installer\Action;
use Pi;
use Pi\Application\Installer\Action\Install as BasicInstall;
use Zend\EventManager\Event;

class Install extends BasicInstall
{
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('install.pre', array($this, 'preInstall'), 1000);
        $events->attach('install.post', array($this, 'postInstall'), 1);
        parent::attachDefaultListeners();
        return $this;
    }

    public function preInstall(Event $e)
    {
        $result = array(
            'status' => true,
            'message' => sprintf('Called from %s', __METHOD__),
        );
        $e->setParam('result', $result);
    }

    public function postInstall(Event $e)
    {
        // Add department
        $config = Pi::service('registry')->config->read('', 'mail');
        $model = Pi::model($module = $e->getParam('module') . '/department');
        $data = array(
            'title' => __('Default'),
            'alias' => __('default'),
            'email' => $config['adminmail'],
            'status' => 1,
        );
        $model->insert($data);

        // Result
        $result = array(
            'status'    => true,
            'message'   => __('Default department added.'),
        );
        $this->setResult('post-install', $result);
    }
}