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
namespace Module\Contact\Api;

use Pi;
use Pi\Application\Api\AbstractBreadcrumbs;

class Breadcrumbs extends AbstractBreadcrumbs
{
    /**
     * {@inheritDoc}
     */
    public function load()
    {
        // Get params
        $params = Pi::service('url')->getRouteMatch()->getParams();
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Check breadcrumbs
        if (!$config['breadcrumbs']) {
            return '';
        }
        // Set module link
        $moduleData = Pi::registry('module')->read($this->getModule());
        // Set index link
        if ($params['action'] == 'index') {
            $href = '';
        } else {
            $href = Pi::service('url')->assemble('default', array(
                'module' => $this->getModule(),
            ));
        }
        // Set result
        $result = array();
        $result[] = array(
            'label' => $moduleData['title'],
            'href'  => $href,
        );
        // Set module internal links
        switch ($params['action']) {
            case 'department':
                $department = Pi::model('department', $this->getModule())->find($params['department'], 'slug')->toArray();
                $result[] = array(
                    'label' => $department['title'],
                );
                break;

            case 'list':
                $result[] = array(
                    'label' => __('List of departments'),
                );
                break;
        }
        return $result;
    }
}
