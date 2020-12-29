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

namespace Module\Contact\Form;

use Module\System\Validator\UserEmail as UserEmailValidator;
use Pi;
use Laminas\InputFilter\InputFilter;

class ReplyFilter extends InputFilter
{
    public function __construct($option = [])
    {
        // department
        $this->add(
            [
                'name'     => 'uid',
                'required' => true,
            ]
        );
        // department
        $this->add(
            [
                'name'     => 'mid',
                'required' => true,
            ]
        );
        // name
        $this->add(
            [
                'name'     => 'name',
                'required' => true,
            ]
        );
        // Check
        if ($option['sms_replay']) {
            // mobile
            $this->add(
                [
                    'name'     => 'mobile',
                    'required' => true,
                ]
            );
        } else {
            // email
            $this->add(
                [
                    'name'       => 'email',
                    'required'   => true,
                    'filters'    => [
                        [
                            'name' => 'StringTrim',
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'EmailAddress',
                            'options' => [
                                'useMxCheck'     => false,
                                'useDeepMxCheck' => false,
                                'useDomainCheck' => false,
                            ],
                        ],
                        new UserEmailValidator(
                            [
                                'blacklist'         => false,
                                'check_duplication' => false,
                            ]
                        ),
                    ],
                ]
            );
        }
        // title
        $this->add(
            [
                'name'     => 'subject',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );
        // Message
        $this->add(
            [
                'name'     => 'message',
                'required' => true,
            ]
        );
    }
}
