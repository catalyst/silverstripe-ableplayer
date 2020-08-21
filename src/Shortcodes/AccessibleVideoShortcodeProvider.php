<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class AccessibleVideoShortcodeProvider implements ShortcodeHandler
{
    use Configurable;

    private static $vimeo_player_url = 'https://player.vimeo.com/api/player.js';
    //pass in a different version of jquery, if you're already using it elsewhere
    //Version 3.2.1 or higher is recommended
    //this needs to match the exact version loaded from //code.jquery.com/jquery-%s.min.js, or jquery will get loaded twice
    private static $jquery_version = '3.5.1';
    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return mixed
     */
    public static function get_shortcodes()
    {
        return [
            'vimeo',
            'youtube'
        ];
    }

    /**
     * Replace "[vimeo id=n] or [youtube id=n]" shortcode w3c markup.
     *
     * @param array $arguments Arguments passed to the parser
     * @param string $content Raw shortcode
     * @param ShortcodeParser $parser Parser
     * @param string $shortcode Name of shortcode used to register this handler
     * @param array $extra Extra arguments
     *
     * @return string Result of the handled shortcode
     */
    public static function handle_shortcode($arguments, $content, $parser, $shortcode, $extra = [])
    {
        $record = null;
        if (isset($arguments['url'])) {
            $record = AccessibleVideo::get()->find('URL', Convert::raw2sql($arguments['url']));

            if (!($record && $record->ID)) {
                $video = AccessibleVideo::create();
                $video->URL = Convert::raw2sql($arguments['url']);
                $video->Type = strtolower($shortcode) == 'youtube' ? 'YouTube' : 'Vimeo';
                $video->write();

                $record = $video;
            }
        }

        if (isset($arguments['id'])) {
            $record = AccessibleVideo::get()->byID((int) $arguments['id']);
        }

        if ($record && $record->ID) {
            $url = sprintf("//code.jquery.com/jquery-%s.min.js", self::config()->jquery_version);
            Requirements::javascript($url);
            Requirements::javascript("catalyst/silverstripe-ableplayer:client/thirdparty/js.cookie.js");
            Requirements::javascript("catalyst/silverstripe-ableplayer:client/build/ableplayer.min.js");
            Requirements::css("catalyst/silverstripe-ableplayer:client/build/ableplayer.min.css");
            if ($record->ID && $record->Type == 'Vimeo') {
                Requirements::javascript(self::config()->vimeo_player_url);
            }
            return SSViewer::execute_template(
                'Catalyst/AblePlayer/AccessibleVideo',
                $record
            );

        }

        return '';
    }

}
