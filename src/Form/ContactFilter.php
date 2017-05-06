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
namespace Module\Contact\Form;

use Pi;
use Zend\InputFilter\InputFilter;
use Module\System\Validator\UserEmail as UserEmailValidator;

class ContactFilter extends InputFilter
{
    public function __construct()
    {
        // Get configs
        $module = Pi::service('module')->current();
        $config = Pi::service('registry')->config->read($module, 'form');
        // User id
        $this->add(array(
            'name' => 'uid',
            'required' => true,
        ));
        // subject
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
            'validators'    => array(
                array(
                    'name'      => 'EmailAddress',
                    'options'   => array(
                        'useMxCheck'        => false,
                        'useDeepMxCheck'    => false,
                        'useDomainCheck'    => false,
                    ),
                ),
                new UserEmailValidator(array(
                    'blacklist'         => false,
                    'check_duplication' => false,
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
                'required' => $config['required_organization'] ? true : false,
            ));
        }
        // Homepage
        if ($config['show_homepage']) {
            $this->add(array(
                'name' => 'homepage',
                'required' => $config['required_homepage'] ? true : false,
            ));
        }
        // Location
        if ($config['show_location']) {
            $this->add(array(
                'name' => 'location',
                'required' => $config['required_location'] ? true : false,
            ));
        }
        // Phone
        if ($config['show_phone']) {
            $this->add(array(
                'name' => 'phone',
                'required' => $config['required_phone'] ? true : false,
            ));
        }
        // Address
        if ($config['show_address']) {
            $this->add(array(
                'name' => 'address',
                'required' => $config['required_address'] ? true : false,
            ));
        }
        // Message
        $this->add(array(
            'name' => 'message',
            'required' => true,
        ));
    }
}	