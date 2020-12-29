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

namespace Module\Contact\Controller\Admin;

use Module\Contact\Form\PruneForm;
use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Contact\Form\PruneForm;
use Module\Contact\Form\SitemapForm;

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
        $select = $this->getModel('department')->select()->columns(['id', 'title']);
        $rowset = $this->getModel('department')->selectWith($select);
        foreach ($rowset as $row) {
            $list[$row->id]    = $row->toArray();
            $options[$row->id] = $list[$row->id]['title'];
        }

        // Set message
        $message = __('You can prune all old message, from selected department.');

        // Set form
        $form    = new PruneForm('prune', $options);
        if ($this->request->isPost()) {

            // Set form date
            $values = $this->request->getPost();

            // Set prune create
            $where = ['`time_create` < ?' => strtotime($values['date'])];

            // Set topics if select
            if ($values['department'] && is_array($values['department'])) {
                $where[] = 'department IN (' . implode(',', $values['department']) . ')';
            }

            // Set prune answer
            if ($values['answer']) {
                $where[] = 'answered = 1 OR mid != 0';
            }

            // Delete message
            $number = $this->getModel('message')->delete($where);
            if ($number) {
                $message = sprintf(__('<strong>%s</strong> old messages removed'), $number);
            } else {
                $message = __('Error in pruned messages.');
            }
        }

        // Set view
        $this->view()->setTemplate('tools-prune');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Tools'));
        $this->view()->assign('message', $message);
    }

    public function sitemapAction()
    {
        // Set message
        $message = __('Rebuild the module links in sitemap module tables');

        // Set form
        $form = new SitemapForm('sitemap');
        if ($this->request->isPost()) {
            Pi::api('sitemap', 'contact')->sitemap();
            $message = __('Sitemap rebuild finished');
        }

        // Set view
        $this->view()->setTemplate('tools-sitemap');
        $this->view()->assign('title', __('Rebuild sitemap links'));
        $this->view()->assign('form', $form);
        $this->view()->assign('message', $message);
    }
}
