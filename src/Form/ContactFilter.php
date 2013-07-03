<?php
/**
 * Contact form
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

namespace Module\Contact\Form;

use Pi;
use Zend\InputFilter\InputFilter;

class ContactFilter extends InputFilter
{
    public function __construct($module)
    {
        // Get configs
        $config = Pi::service('registry')->config->read($module, 'form');
        // name
        $this->add(array(
            'name' => 'author',
            'required' => true,
        ));
        // title
        $this->add(array(
            'name' => 'subject',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        ));
        // department
        $this->add(array(
            'name' => 'department',
            'required' => true,
        ));
        // email
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'useMxCheck' => false,
                        'useDeepMxCheck' => false,
                        'useDomainCheck' => false,
                    ),
                ),
                new \Module\System\Validator\UserEmail(array(
                    'backlist' => false,
                    'checkDuplication' => false,
                )),
            ),
        ));
        // name
        $this->add(array(
            'name' => 'name',
            'required' => true,
        ));
        // Organization
        if ($config['show_organization']) {
            $this->add(array(
                'name' => 'organization',
                'required' => false,
            ));
        }
        // Homepage
        if ($config['show_homepage']) {
            $this->add(array(
                'name' => 'homepage',
                'required' => false,
            ));
        }
        // Location
        if ($config['show_location']) {
            $this->add(array(
                'name' => 'location',
                'required' => false,
            ));
        }
        // Phone
        if ($config['show_phone']) {
            $this->add(array(
                'name' => 'phone',
                'required' => false,
            ));
        }
        // Address
        if ($config['show_address']) {
            $this->add(array(
                'name' => 'address',
                'required' => false,
            ));
        }
        // Message
        $this->add(array(
            'name' => 'message',
            'required' => true,
        ));
    }
}	