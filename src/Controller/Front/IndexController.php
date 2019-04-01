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

namespace Module\Contact\Controller\Front;

use Module\Contact\Form\ContactFilter;
use Module\Contact\Form\ContactForm;
use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Set info
        $module = $this->params('module');

        // Get config
        $config = Pi::service('registry')->config->read($module);

        // Check block time for allow submit contact
        $allowSubmit = true;
        if (isset($_SESSION['CONTACT'])) {
            $diffTime = floor((time() - $_SESSION['CONTACT']['TIME']) / 60);
            if ($config['block_time'] > $diffTime) {
                $allowSubmit = false;
            }
        }

        // Check use contact form allowed or not
        if ($allowSubmit) {

            // Set form option
            $option = [
                'captcha' => 1,
                'config'  => $config,
            ];

            // Set form
            $form = new ContactForm('contact', $option);

            // Get post
            if ($this->request->isPost()) {
                $data = $this->request->getPost();
                $form->setInputFilter(new ContactFilter($option));
                $form->setData($data);
                if ($form->isValid()) {
                    $values = $form->getData();

                    // Set values
                    $values['uid']         = Pi::user()->getId();
                    $values['ip']          = Pi::user()->getIp();
                    $values['time_create'] = time();
                    $values['name']        = _strip($values['name']);
                    $values['subject']     = _strip($values['subject']);
                    $values['message']     = _strip($values['message']);

                    // Save
                    $row = $this->getModel('message')->createRow();
                    $row->assign($values);
                    $row->save();

                    // Set session
                    $_SESSION['CONTACT'] = [
                        'TIME' => $values['time_create'],
                        'IP'   => $values['ip'],
                    ];

                    // Get department
                    $department = $this->getModel('department')->find($values['department'])->toArray();

                    // Set department
                    $values['department_title'] = $department['title'];
                    $values['department_email'] = $department['email'];

                    // Send as mail
                    Pi::api('mail', 'contact')->toAdmin($values);
                    Pi::api('mail', 'contact')->toUser($values);

                    // Set message
                    $message = __('Message correctly Send, a confirmation has just been sent to you by email');
                    $message = (!empty($config['finishtext'])) ? $config['finishtext'] : $message;

                    // Jump
                    $this->jump(['action' => 'index'], $message);
                }
            } else {
                // Set data
                $data = [
                    'department' => $config['default_department'],
                ];

                // Get user information
                if (Pi::service('authentication')->hasIdentity()) {
                    $user          = Pi::user()->get(Pi::user()->getId(), ['id', 'name', 'email']);
                    $data['name']  = $user['name'];
                    $data['email'] = $user['email'];
                }

                // Set data
                $form->setData($data);
            }

            // Set view
            $this->view()->assign('form', $form);
        }

        // Set map setting
        $mapSetting = [];
        if ($config['map_show']) {
            if (Pi::config('map_type') == 'osm') {
                $mapSetting = [
                    'type'   => 'osm',
                    'params' => [
                        'type'      => 'point',
                        'latitude'  => round(!empty($config['map_latitude']) ? $config['map_latitude'] : Pi::config('geo_latitude'), 6),
                        'longitude' => round(!empty($config['map_longitude']) ? $config['map_longitude'] : Pi::config('geo_longitude'), 6),
                        'zoom'      => $config['map_zoom'],
                        'title'     => !empty($config['map_title']) ?: Pi::config('geo_placename'),
                    ],
                ];
            } else {
                $mapSetting = [
                    'type'     => 'google',
                    'key'      => Pi::config('google_map_key'),
                    'location' => [
                        'latitude'  => round(!empty($config['map_latitude']) ? $config['map_latitude'] : Pi::config('geo_latitude'), 6),
                        'longitude' => round(!empty($config['map_longitude']) ? $config['map_longitude'] : Pi::config('geo_longitude'), 6),
                        'zoom'      => $config['map_zoom'],
                        'title'     => !empty($config['map_title']) ?: Pi::config('geo_placename'),
                    ],
                    'option'   => [
                        'mapTypeId' => $config['map_type'],
                    ],
                ];
            }
        }

        // Set view
        $this->view()->setTemplate('contact-form');
        $this->view()->assign('title', __('Contact Us'));
        $this->view()->assign('config', $config);
        $this->view()->assign('allowSubmit', $allowSubmit);
        $this->view()->assign('mapSetting', $mapSetting);
    }
}