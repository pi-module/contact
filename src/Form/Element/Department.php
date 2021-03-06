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

namespace Module\Contact\Form\Element;

use Pi;
use Laminas\Form\Element\Select;

class Department extends Select
{
    /**
     * @return array
     */
    public function getValueOptions()
    {
        if (empty($this->valueOptions)) {
            $columns = ['id', 'title'];
            $where   = ['status' => 1];
            $select  = Pi::model('department', $this->options['module'])->select()->columns($columns)->where($where);
            $rowset  = Pi::model('department', $this->options['module'])->selectWith($select);
            foreach ($rowset as $row) {
                $list[$row->id]    = $row->toArray();
                $options[$row->id] = $list[$row->id]['title'];
            }
            $this->valueOptions = $options;
        }

        return $this->valueOptions;
    }
}
