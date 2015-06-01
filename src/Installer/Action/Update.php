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
namespace Module\Contact\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Update as BasicUpdate;
use Pi\Application\Installer\SqlSchema;
use Zend\EventManager\Event;

class Update extends BasicUpdate
{
    /**
     * {@inheritDoc}
     */
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('update.pre', array($this, 'updateSchema'));
        parent::attachDefaultListeners();
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function updateSchema(Event $e)
    {
        $moduleVersion    = $e->getParam('version');
        
        // Set message model
        $messageModel        = Pi::model('message', $this->module);
        $messageTable        = $messageModel->getTable();
        $messageAdapter      = $messageModel->getAdapter();

        // Update to version 1.2.9
        if (version_compare($moduleVersion, '1.2.9', '<')) {
            // Alter table : CHANGE message
            $sql = sprintf("ALTER TABLE %s CHANGE `message` `message` text", 
                $messageTable);
            try {
                $messageAdapter->query($sql, 'execute');
            } catch (\Exception $exception) {
                $this->setResult('db', array(
                    'status'    => false,
                    'message'   => 'Table alter query failed: '
                                   . $exception->getMessage(),
                ));
                return false;
            }
        }

        return true;
    }
}   