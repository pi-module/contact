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

namespace Module\Contact\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Install as BasicInstall;
use Laminas\EventManager\Event;

class Install extends BasicInstall
{
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('install.pre', [$this, 'preInstall'], 1000);
        $events->attach('install.post', [$this, 'postInstall'], 1);
        parent::attachDefaultListeners();
        return $this;
    }

    public function preInstall(Event $e)
    {
        $result = [
            'status'  => true,
            'message' => sprintf('Called from %s', __METHOD__),
        ];
        $e->setParam('result', $result);
    }

    public function postInstall(Event $e)
    {
        // Add department
        $config = Pi::service('registry')->config->read('', 'mail');
        $model  = Pi::model($module = $e->getParam('module') . '/department');
        $data   = [
            'title'  => __('Default department'),
            'slug'   => __('default'),
            'email'  => $config['adminmail'],
            'status' => 1,
        ];
        $model->insert($data);

        // Result
        $result = [
            'status'  => true,
            'message' => __('Default department added.'),
        ];
        $this->setResult('post-install', $result);
    }
}