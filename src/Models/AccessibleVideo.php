<?php
namespace Catalyst\AblePlayer;

use SilverStripe\ORM\DataObject;

class AccessibleVideo extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Type' => 'Enum("Vimeo,YouTube", "YouTube")',
        'URL' => 'Varchar(255)',
    ];

    private static $has_many = [
        'Captions' => AccessibleVideoCaption::class,
        'AudioDescriptions' => AccessibleVideoAudioDescription::class
    ];

    private static $table_name = 'AccessibleVideo';
    private static $default_sort = 'Title ASC';
    private static $singular_name = 'Video';
    private static $plural_name = 'Videos';

    //pass in a different version of jquery, if you're already using it elsewhere
    //Version 3.2.1 or higher is recommended
    //this needs to match the exact version loaded from //code.jquery.com/jquery-%s.min.js, or jquery will get loaded twice
    private static $jquery_version = '3.5.1';

    private static $summary_fields = [
        'URL' => "Link",
        'Title' => "Title",
        'Captions.Count' => 'Caption tracks',
        'AudioDescriptions.Count' => 'Audio descriptions'
    ];

    public function YouTubeID()
    {
        if($this->Type !== 'YouTube') return null;

        //https://stackoverflow.com/questions/42440678/regular-expression-for-youtube-video-id
        if(preg_match("#^(?:https?:)?//[^/]*(?:youtube(?:-nocookie)?\.com|youtu\.be).*[=/]([-\\w]{11})(?:\\?|=|&|$)#", $this->URL, $matches))
        {
            if(isset($matches[1])) {
                return $matches[1];
            }
        }
    }

    public function VimeoID()
    {
        if($this->Type !== 'Vimeo') return null;

        if(preg_match("#(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)#", $this->URL, $matches))
        {
            if(isset($matches[4])) {
                return $matches[4];
            }
        }
    }
}
