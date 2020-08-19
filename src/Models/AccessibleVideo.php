<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;

class AccessibleVideo extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Type' => 'Enum("Vimeo,YouTube", "YouTube")',
        'URL' => 'Varchar(255)'
    ];

    private static $table_name = 'AccessibleVideo';
    private static $default_sort = 'Title ASC';
    private static $singular_name = 'Video';
    private static $plural_name = 'Videos';

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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Requirements::javascript("//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js");
        // Requirements::javascript('catalyst/silverstripe-ableplayer:client/dist/js.cookie.js');
        // Requirements::css('catalyst/silverstripe-ableplayer:client/dist/ableplayer.min.css');
        // Requirements::javascript('catalyst/silverstripe-ableplayer:client/dist/ableplayer.js');
        $fields->addFieldToTab(
            'Root.Main',
            TextareaField::create(
                'AccessibleVideoHTML',
                'Markup',
                SSViewer::execute_template(
                    'Catalyst/AblePlayer/AccessibleVideo',
                    $this
                )
            )
        );
        return $fields;
    }
}
