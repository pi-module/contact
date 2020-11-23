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

namespace Module\Contact\Model;

use Pi\Application\Model\Model;

class Message extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns
        = [
            'id',
            'subject',
            'department',
            'email',
            'name',
            'organization',
            'homepage',
            'location',
            'phone',
            'ip',
            'address',
            'message',
            'mid',
            'answered',
            'uid',
            'time_create',
            'platform',
            'attachment'
        ];
}