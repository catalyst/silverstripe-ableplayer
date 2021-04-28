<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Convert;
use SilverStripe\View\Parsers\ShortcodeHandler;

class SelfHostedVideoShortcodeProvider extends AbleShortcodeProvider implements ShortcodeHandler
{
    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return mixed
     */
    public static function get_shortcodes()
    {
        return [
            'selfhostedvideo'
        ];
    }

    /**
     * Replace [self-hosted-video id=n]" shortcode with w3c markup
     *
     * id is an SelfHostedVideo record loaded in the CMS, which is matched to a
     * record with that ID
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
        if (isset($arguments['id'])) {
            $record = SelfHostedVideo::get()->byID((int) $arguments['id']);

            if ($record && $record->ID) {
                return static::render($record);
            }
        }
        return '';
    }

}
