<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Convert;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Requirements;

class VimeoShortcodeProvider extends AbleShortcodeProvider implements ShortcodeHandler
{
    private static $vimeo_player_url = 'https://player.vimeo.com/api/player.js';

    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return mixed
     */
    public static function get_shortcodes()
    {
        return [
            'vimeo'
        ];
    }

    /**
     * Replace [vimeo id=n]" shortcode with w3c markup, or
     * Replace [vimeo url=n]" shortcode with w3c markup
     *
     * id is an AccessibleVideo record loaded in the CMS. url is a Vimeo URL,
     * which is matched to an AccessibleVideo record with that URL
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
            $record = Vimeo::get()->find('URL', Convert::raw2sql($arguments['url']));

            if (!($record && $record->ID)) {
                $video = Vimeo::create();
                $video->URL = Convert::raw2sql($arguments['url']);
                $video->write();

                $record = $video;
            }
        }

        if (isset($arguments['id'])) {
            $record = Vimeo::get()->byID((int) $arguments['id']);
        }

        if ($record && $record->ID) {
            Requirements::javascript(self::config()->vimeo_player_url);
            return static::render($record);
        }

        return '';
    }

}
