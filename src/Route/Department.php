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
namespace Module\Contact\Route;

use Pi\Mvc\Router\Http\Standard;

class Department extends Standard
{
    /**
     * Default values.
     * @var array
     */
    protected $defaults = array(
        'module'        => 'contact',
        'controller'    => 'index',
        'action'        => 'index'
    );

    protected $prefix = '/contact';

    /**
     * {@inheritDoc}
     */
    protected $structureDelimiter = '/';

    /**
     * {@inheritDoc}
     */
    protected function parse($path)
    {
        $matches = array();
        $parts = array_filter(explode($this->structureDelimiter, $path));

        // Set controller
        $matches = array_merge($this->defaults, $matches);
        if (isset($parts[0]) && $parts[0] == 'department') {
            $matches['action'] = 'department';
            $matches['department'] = $this->decode($parts[1]);
        } else {
            $matches['action'] = isset($parts[0]) ? $this->decode($parts[0]) : 'index';
            if ($matches['action'] == 'finish' && !empty($parts[1])) {
                $matches['hash'] = $parts[1];
            }
        }
        return $matches;
    }

    /**
     * assemble(): Defined by Route interface.
     *
     * @see    Route::assemble()
     * @param  array $params
     * @param  array $options
     * @return string
     */
    public function assemble(
        array $params = array(),
        array $options = array()
    ) {
        $mergedParams = array_merge($this->defaults, $params);
        if (!$mergedParams) {
            return $this->prefix;
        }

        if (!empty($mergedParams['module'])) {
            $url['module'] = $mergedParams['module'];
        }

        if (!empty($mergedParams['action']) && $mergedParams['action'] != 'index') {
            $url['action'] = $mergedParams['action'];
        }

        if (!empty($mergedParams['department'])) {
            $url['department'] = 'department' . $this->paramDelimiter . $mergedParams['department'];
        }

        if (!empty($mergedParams['hash'])) {
            $url['hash'] = $mergedParams['hash'];
        }

        $url = implode($this->paramDelimiter, $url);

        if (empty($url)) {
            return $this->prefix;
        }
        return $this->paramDelimiter . $url;
    }
}