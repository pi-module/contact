<?php
/**
 * Contact admin Tools controller
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
            $where = array('`create` < ?' => strtotime($values['date']));
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