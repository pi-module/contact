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

class DepartmentFilter extends InputFilter
{
    public function __construct()
    {
        // id
        $this->add(
            [
                'name'     => 'id',
                'required' => false,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );
        // title
        $this->add(
            [
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );
        // slug
        $this->add(
            [
                'name'       => 'slug',
                'required'   => false,
                'filters'    => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
                'validators' => [
                    new \Module\Contact\Validator\SlugDuplicate(
                        [
                            'module' => Pi::service('module')->current(),
                            'table'  => 'department',
                        ]
                    ),
                ],
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
        // status
        $this->add(
            [
                'name'     => 'status',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );
    }
}
