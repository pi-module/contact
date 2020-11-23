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
use Pi\Application\Installer\Action\Update as BasicUpdate;
use Pi\Application\Installer\SqlSchema;
use Laminas\EventManager\Event;

class Update extends BasicUpdate
{
    /**
     * {@inheritDoc}
     */
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('update.pre', [$this, 'updateSchema']);
        parent::attachDefaultListeners();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function updateSchema(Event $e)
    {
        $moduleVersion = $e->getParam('version');

        // Set message model
        $messageModel   = Pi::model('message', $this->module);
        $messageTable   = $messageModel->getTable();
        $messageAdapter = $messageModel->getAdapter();

        // Update to version 1.2.9
        if (version_compare($moduleVersion, '1.2.9', '<')) {
            // Alter table : CHANGE message
            $sql = sprintf(
                "ALTER TABLE %s CHANGE `message` `message` text",
                $messageTable
            );
            try {
                $messageAdapter->query($sql, 'execute');
            } catch (\Exception $exception) {
                $this->setResult(
                    'db', [
                        'status'  => false,
                        'message' => 'Table alter query failed: '
                            . $exception->getMessage(),
                    ]
                );
                return false;
            }
        }

        // Update to version 1.6.0
        if (version_compare($moduleVersion, '1.6.0', '<')) {
            // Alter table : CHANGE message
            $sql = sprintf("ALTER TABLE %s ADD `attachment` VARCHAR(255) NOT NULL DEFAULT ''", $messageTable);
            try {
                $messageAdapter->query($sql, 'execute');
            } catch (\Exception $exception) {
                $this->setResult(
                    'db', [
                        'status'  => false,
                        'message' => 'Table alter query failed: '
                            . $exception->getMessage(),
                    ]
                );
                return false;
            }
        }

        return true;
    }
}   