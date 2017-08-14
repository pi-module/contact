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

class ReplyFilter extends InputFilter
{
    public function __construct($option = array())
    {
        // department
        $this->add(array(
            'name' => 'uid',
            'required' => true,
        ));
        // department
        $this->add(array(
            'name' => 'mid',
            'required' => true,
        ));
        // name
        $this->add(array(
            'name' => 'name',
            'required' => true,
        ));
        // Check
        if ($option['sms_replay']) {
            // mobile
            $this->add(array(
                'name' => 'mobile',
                'required' => true,
            ));
        } else {
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
        }
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
        // Message
        $this->add(array(
            'name' => 'message',
            'required' => true,
        ));
    }
}	    	