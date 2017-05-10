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
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;
use Module\Contact\Form\DepartmentForm;
use Module\Contact\Form\DepartmentFilter;

class DepartmentController extends ActionController
{
    public function indexAction()
    {
        // Get info
        $select = $this->getModel('department')->select()->order(array('id DESC'));
        $rowset = $this->getModel('department')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
        }
        // Set view
        $this->view()->setTemplate('department-index');
        $this->view()->assign('departments', $list);

    }

    public function updateAction()
    {
        $id = $this->params('id');
        $form = new DepartmentForm('department');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            // Set slug
            $slug = ($data['slug']) ? $data['slug'] : $data['title'];
            $filter = new Filter\Slug;
            $data['slug'] = $filter($slug);
            // Form filter
            $form->setInputFilter(new DepartmentFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
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
                }
            }
        } else {
            if ($id) {
                $values = $this->getModel('department')->find($id)->toArray();
                $form->setData($values);
            }
        }
        // Set view
        $this->view()->setTemplate('department-update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Add a Department'));
    }

    public function deleteAction()
    {
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