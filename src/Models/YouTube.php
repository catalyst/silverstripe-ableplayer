<?php
namespace Catalyst\AblePlayer;

class YouTube extends AccessibleVideo
{
    private static $table_name = 'YouTube';
    private static $db = [
        'URL' => 'Varchar(255)',
    ];
    private static $singular_name = 'YouTube Video';
    private static $plural_name = 'YouTube Videos';

    private static $summary_fields = [
        'URL' => 'Link'
    ];

    /**
     * Extract the YouTube identifier from the record's URL
     *
     * @return mixed string identifier, or null if not a recognizable YouTube video
     */
    public function YouTubeID()
    {
        //https://stackoverflow.com/questions/42440678/regular-expression-for-youtube-video-id
        if(preg_match("#^(?:https?:)?//[^/]*(?:youtube(?:-nocookie)?\.com|youtu\.be).*[=/]([-\\w]{11})(?:\\?|=|&|$)#", $this->URL, $matches))
        {
            if(isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }
}
