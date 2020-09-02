<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class AccessiblePlayerAdmin extends ModelAdmin
{
    private static $managed_models = [
        YouTube::class,
        Vimeo::class,
        SelfHostedVideo::class
    ];

    private static $menu_title = 'Accessible Videos';

    private static $url_segment = 'accessible';

}
