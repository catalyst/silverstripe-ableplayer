<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\DropdownField;

use SilverStripe\Forms\TextField;
use SilverStripe\i18n\Data\Intl\IntlLocales;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;

class AccessibleVideo extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Type' => 'Enum("Vimeo,YouTube", "YouTube")',
        'URL' => 'Varchar(255)',
        'CaptionsTrackLabel' => 'Varchar(80)',
        'CaptionsTrackLang' => 'Varchar(3)'
    ];

    private static $has_one = [
        'CaptionsTrack' => File::class
    ];

    private static $defaults = [
        'CaptionsTrackLang' => 'en'
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
        'Title' => "Title"
    ];

    private static $owns = [
        'CaptionsTrack'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab(
            'Root.Captions',
            [
                UploadField::create('CaptionsTrack', 'Captions Track')
                    ->setDescription('Web VTT file prepared for this video. This is written text shown underneath spoken words for users unable to hear. For more on this format, see <a href="https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format" target="_blank">this article</a>'),
                DropdownField::create(
                    'CaptionsTrackLang',
                    'Source Language'
                )->setSource(IntlLocales::config()->languages),
                TextField::create('CaptionsTrackLabel', 'Label')
            ]
        );

        return $fields;
    }


    public function __construct($record = null, $isSingleton = false, $queryParams = [])
    {
        parent::__construct($record, $isSingleton, $queryParams);
        $url = sprintf("//code.jquery.com/jquery-%s.min.js", $this->config()->jquery_version);
        Requirements::javascript($url);
        Requirements::javascript("catalyst/silverstripe-ableplayer:client/thirdparty/js.cookie.js");
        Requirements::javascript("catalyst/silverstripe-ableplayer:client/build/ableplayer.min.js");
        Requirements::css("catalyst/silverstripe-ableplayer:client/build/ableplayer.min.css");
        if ($this->ID && $this->Type == 'Vimeo') {
            Requirements::javascript('https://player.vimeo.com/api/player.js');
        }
    }

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
