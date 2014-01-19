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
    public function indexAction()
    {
        // Get department list row
        $select = Pi::model('department', $this->params('module'))->select()->columns(array('id', 'title'));
        $rowset = Pi::model('department', $this->params('module'))->selectWith($select);
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
            $number = Pi::model('message', $this->params('module'))->delete($where);
            if ($number) {
                // Set class
                $message = sprintf(__('<strong>%s</strong> old messages removed'), $number);
            } else {
                // Set class
                $message = __('Error in pruned messages.');
            }
        }
        $this->view()->setTemplate('tools_index');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Tools'));
        $this->view()->assign('message', $message);
    }
}