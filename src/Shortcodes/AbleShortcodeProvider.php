<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

abstract class AbleShortcodeProvider
{
    use Configurable;

    //pass in a different version of jquery, if you're already using it elsewhere
    //Version 3.2.1 or higher is recommended
    //this needs to match the exact version loaded from //code.jquery.com/jquery-%s.min.js, or jquery will get loaded twice
    private static $jquery_version = '3.5.1';

    /**
     * All video players load required libraries
     *
     * @param [mixed] $record Vimeo or YouTube records
     * @return string
     */
    public static function render($record)
    {
        $url = sprintf("//code.jquery.com/jquery-%s.min.js", static::config()->jquery_version);
        Requirements::javascript($url);
        Requirements::javascript("catalyst/silverstripe-ableplayer:client/able/thirdparty/js.cookie.js");
        Requirements::javascript("catalyst/silverstripe-ableplayer:client/able/build/ableplayer.min.js");
        Requirements::css("catalyst/silverstripe-ableplayer:client/able/build/ableplayer.min.css");

        return SSViewer::execute_template(
            'Catalyst/AblePlayer/AccessibleVideo',
            $record
        );
    }

}
