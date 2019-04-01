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

namespace Module\Contact\Route;

use Pi\Mvc\Router\Http\Standard;

class Department extends Standard
{
    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults
        = [
            'module'     => 'contact',
            'controller' => 'index',
            'action'     => 'index',
        ];

    //protected $prefix = '/contact';

    /**
     * {@inheritDoc}
     */
    protected $structureDelimiter = '/';

    /**
     * {@inheritDoc}
     */
    protected function parse($path)
    {
        $matches = [];
        $parts   = array_filter(explode($this->structureDelimiter, $path));

        // Set controller
        $matches = array_merge($this->defaults, $matches);
        /* if (isset($parts[0]) && $parts[0] == 'department') {
            $matches['action'] = 'department';
            $matches['department'] = $this->decode($parts[1]);
        } else {
            $matches['action'] = isset($parts[0]) ? $this->decode($parts[0]) : 'index';
            if (isset($parts[1]) && $parts[1] == 'password') {
                $matches['password'] = $this->decode($parts[2]);
            }
        } */

        $matches['action'] = isset($parts[0]) ? $this->decode($parts[0]) : 'index';
        if (isset($parts[1]) && $parts[1] == 'password') {
            $matches['password'] = $this->decode($parts[2]);
        }

        /* echo '<pre>';
        print_r($matches);
        print_r($parts);
        echo '</pre>'; */

        return $matches;
    }

    /**
     * assemble(): Defined by Route interface.
     *
     * @see    Route::assemble()
     *
     * @param  array $params
     * @param  array $options
     *
     * @return string
     */
    public function assemble(
        array $params = [],
        array $options = []
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

        /* if (!empty($mergedParams['department'])) {
            $url['department'] = 'department' . $this->paramDelimiter . $mergedParams['department'];
        } */

        // Set password
        if (!empty($mergedParams['password'])) {
            $url['password'] = 'password' . $this->paramDelimiter . $mergedParams['password'];
        }

        $url = implode($this->paramDelimiter, $url);

        if (empty($url)) {
            return $this->prefix;
        }

        $finalUrl = rtrim($this->paramDelimiter . $url, '/');

        return $finalUrl;
    }
}