<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\SSViewer;

class AccessibleVideoShortcodeProvider implements ShortcodeHandler
{
    use Configurable;

    private static $vimeo_player_url = 'https://player.vimeo.com/api/player.js';
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
        $record = AccessibleVideo::get()->byID( (int) $arguments['id']);
        return SSViewer::execute_template(
            'Catalyst/AblePlayer/AccessibleVideo',
            $record
        );
    }

}
