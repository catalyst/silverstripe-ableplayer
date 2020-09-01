<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class YouTubeShortcodeProvider extends AccessibleVideoShortcodeProvider implements ShortcodeHandler
{
    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return mixed
     */
    public static function get_shortcodes()
    {
        return [
            'youtube'
        ];
    }

    /**
     * Replace [youtube id=n]" shortcode with w3c markup, or
     * Replace [youtube url=n]" shortcode with w3c markup
     *
     * id is an AccessibleVideo record loaded in the CMS. url is a YouTube URL,
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
            $record = YouTube::get()->find('URL', Convert::raw2sql($arguments['url']));

            if (!($record && $record->ID)) {
                $video = YouTube::create();
                $video->URL = Convert::raw2sql($arguments['url']);
                $video->write();

                $record = $video;
            }
        }

        if (isset($arguments['id'])) {
            $record = YouTube::get()->byID((int) $arguments['id']);
        }

        if ($record && $record->ID) {
            return static::render($record);
        }

        return '';
    }

}
