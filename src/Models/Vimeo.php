<?php
namespace Catalyst\AblePlayer;

use SilverStripe\View\Requirements;

class Vimeo extends AccessibleVideo
{
    private static $table_name = 'Vimeo';
    private static $db = [
        'URL' => 'Varchar(255)',
    ];
    private static $singular_name = 'Vimeo Video';
    private static $plural_name = 'Vimeo Videos';

    private static $summary_fields = [
        'URL' => 'Link'
    ];

    private static $vimeo_player_url = 'https://player.vimeo.com/api/player.js';
]

    /**
     * Extract the Vimeo identifier from the record's URL
     *
     * @return mixed string identifier, or null if not a recognizable Vimeo video
     */
    public function VimeoID()
    {
        if(preg_match("#(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)#", $this->URL, $matches))
        {
            if(isset($matches[4])) {
                return $matches[4];
            }
        }

        return null;

    }


    /**
     * Load Vimeo Player Javascript for frontend templates
     *
     * @return void
     */
    public function GetVimeoPlayer()
    {
        Requirements::javascript(self::config()->vimeo_player_url)
    }
}
