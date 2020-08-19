<?php
/**
 * Register the default internal shortcodes.
 */

use Catalyst\AblePlayer\AccessibleVideoShortcodeProvider;
use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')
    ->register(
        'vimeo',
        [AccessibleVideoShortcodeProvider::class, 'handle_shortcode']
    );

ShortcodeParser::get('default')
    ->register(
        'youtube',
        [AccessibleVideoShortcodeProvider::class, 'handle_shortcode']
    );


