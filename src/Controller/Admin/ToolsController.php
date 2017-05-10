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
namespace Module\Contact\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Contact\Form\PruneForm;

class ToolsController extends ActionController
{
    public function settingAction()
    {
        // Set view
        $this->view()->setTemplate('tools-setting');
    }

    public function pruneAction()
    {
        // Get department list row
        $select = $this->getModel('department')->select()->columns(array('id', 'title'));
        $rowset = $this->getModel('department')->selectWith($select);
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $options[$row->id] = $list[$row->id]['title'];
        }
        $form = new PruneForm('prune', $options);
        $message = __('You can prune all old message, from selected department.');
        if ($this->request->isPost()) {
            // Set form date
            $values = $this->request->getPost();
            // Set prune create
            $where = array('`time_create` < ?' => strtotime($values['date']));
            // Set topics if select
            if ($values['department'] && is_array($values['department'])) {
                $where[] = 'department IN (' . implode(',', $values['department']) . ')';
            }
            // Set prune answer
            if ($values['answer']) {
                $where[] = 'answered = 1 OR mid != 0';
            }
            // Delete storys
            $number = $this->getModel('message')->delete($where);
            if ($number) {
                // Set class
                $message = sprintf(__('<strong>%s</strong> old messages removed'), $number);
            } else {
                // Set class
                $message = __('Error in pruned messages.');
            }
        }
        // Set view
        $this->view()->setTemplate('tools-prune');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Tools'));
        $this->view()->assign('message', $message);
    }

    public function jsonAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get config
        $links = array();
        $links['postContact'] = Pi::url($this->url('guide', array(
            'module' => $module,
            'controller' => 'index',
            'action' => 'ajax',
            'password' => (!empty($config['json_password'])) ? $config['json_password'] : '',
        )));
        // Set template
        $this->view()->setTemplate('tools-json');
        $this->view()->assign('links', $links);
    }
}