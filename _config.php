<?php
/**
 * Register the default internal shortcodes.
 */

use Catalyst\AblePlayer\VimeoShortcodeProvider;
use Catalyst\AblePlayer\YouTubeShortcodeProvider;
use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')
    ->register(
        'vimeo',
        [VimeoShortcodeProvider::class, 'handle_shortcode']
    );

ShortcodeParser::get('default')
    ->register(
        'youtube',
        [YouTubeShortcodeProvider::class, 'handle_shortcode']
    );


