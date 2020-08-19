<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Admin\ModelAdmin;

class AccessiblePlayerAdmin extends ModelAdmin
{
    private static $managed_models = [
        AccessibleVideo::class
    ];

    private static $menu_title = 'Accessible Videos';

    private static $url_segment = 'accessible';
}
