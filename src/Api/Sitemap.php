<?php

namespace Module\Contact\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

class Sitemap extends AbstractApi
{
    public function sitemap()
    {
        if (!Pi::service('module')->isActive('sitemap')) {
            return;
        }

        // Remove old links
        Pi::api('sitemap', 'sitemap')->removeAll('contact', 'contact');

        $loc = Pi::url(Pi::service("url")->assemble("contact"));
        Pi::api('sitemap', 'sitemap')->singleLink($loc, 1, 'contact', 'contact', 0);
    }
}
