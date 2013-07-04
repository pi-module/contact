<?php
/**
 * Contact admin department controller
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
use Module\Contact\Form\DepartmentForm;
use Module\Contact\Form\DepartmentFilter;

class DepartmentController extends ActionController
{
    protected $departmentColumns = array(
        'id', 'title', 'alias', 'email', 'status'
    );

    public function indexAction()
    {
        // Set template
        $this->view()->setTemplate('department_index');
        // Get info
        $select = $this->getModel('department')->select()->order(array('id DESC'));
        $rowset = $this->getModel('department')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
        }
        // Set view
        $this->view()->assign('departments', $list);

    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = new DepartmentForm('department');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new DepartmentFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->departmentColumns)) {
                        unset($values[$key]);
                    }
                }
                // Set alias
                $values['alias'] = Pi::service('api')->contact(array('Text', 'alias'), $values['title'], $values['id'], $this->getModel('department'));
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('department')->find($values['id']);
                } else {
                    $row = $this->getModel('department')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Check it save or not
                if ($row->id) {
                    $message = __('Department data saved successfully.');
                    $this->jump(array('action' => 'index'), $message);
                } else {
                    $message = __('Department data not saved.');
                }
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }
        } else {
            if ($id) {
                $values = $this->getModel('department')->find($id)->toArray();
                $form->setData($values);
                $message = __('You can edit this departments');
            } else {
                $message = __('You can add new this departments');
            }
        }
        $this->view()->setTemplate('department_update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Add a Department'));
        $this->view()->assign('message', $message);
    }

    public function deleteAction()
    {
        /*
           * not completed and need confirm option
           */
        // Get information
        $this->view()->setTemplate(false);
        $id = $this->params('id');
        $row = $this->getModel('department')->find($id);
        if ($row) {
            // Remove message
            $this->getModel('message')->delete(array('department' => $row->id));
            // Remove page
            $row->delete();
            $this->jump(array('action' => 'index'), __('Your selected department deleted'));
        }
        $this->jump(array('action' => 'index'), __('Please select department'));
    }
}