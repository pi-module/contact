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

class ContactFilter extends InputFilter
{
    public function __construct($option = [])
    {
        // subject
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

        // department
        $this->add(
            [
                'name'     => 'department',
                'required' => true,
            ]
        );

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

        // name
        $this->add(
            [
                'name'     => 'name',
                'required' => true,
            ]
        );

        // Organization
        if ($option['config']['show_organization']) {
            $this->add(
                [
                    'name'     => 'organization',
                    'required' => $option['config']['required_organization'] ? true : false,
                ]
            );
        }

        // Homepage
        if ($option['config']['show_homepage']) {
            $this->add(
                [
                    'name'     => 'homepage',
                    'required' => $option['config']['required_homepage'] ? true : false,
                ]
            );
        }

        // Location
        if ($option['config']['show_location']) {
            $this->add(
                [
                    'name'     => 'location',
                    'required' => $option['config']['required_location'] ? true : false,
                ]
            );
        }

        // Phone
        if ($option['config']['show_phone']) {
            $this->add(
                [
                    'name'     => 'phone',
                    'required' => $option['config']['required_phone'] ? true : false,
                ]
            );
        }

        // Address
        if ($option['config']['show_address']) {
            $this->add(
                [
                    'name'     => 'address',
                    'required' => $option['config']['required_address'] ? true : false,
                ]
            );
        }

        // Message
        $this->add(
            [
                'name'     => 'message',
                'required' => true,
            ]
        );
    }
}	