<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Assets\File;
use SilverStripe\Forms\LiteralField;

class SelfHostedVideo extends AccessibleVideo
{
    private static $table_name = 'SelfHostedVideo';
    private static $has_one = [
        'Video' => File::class
    ];
    private static $owns = ['Video'];
    private static $singular_name = 'Self-hosted Video';
    private static $plural_name = 'Self-hosted Videos';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            'Root.Main',
            LiteralField::create(
                'DisplayShortcode',
                '<div class="info message">Embed this video with [self-hosted-video id='.$this->ID.']</div>'
            )
        );

        return $fields;
    }
}
