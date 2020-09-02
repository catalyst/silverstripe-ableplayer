<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Assets\File;
use SilverStripe\Forms\LiteralField;

class SelfHostedVideo extends AccessibleVideo
{
    private static $table_name = 'SelfHostedVideo';
    private static $has_one = [
        'Video' => File::class,
        'SignLanguageVideo' => File::class,
        'DescribedVideo' => File::class
    ];
    private static $owns = [
        'Video',
        'SignLanguageVideo',
        'DescribedVideo'
    ];
    private static $singular_name = 'Self-hosted Video';
    private static $plural_name = 'Self-hosted Videos';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab(
            'Root.Main',
            [
                $fields->datafieldByName('Video')
                    ->setDescription('This is the original unaltered video you want to self-host.'),
                $fields->datafieldByName('SignLanguageVideo')
                    ->setDescription('This is a sign-language interpretation of the spoken content in the video. This is intended for users who understand sign-language.'),
                $fields->datafieldByName('DescribedVideo')
                    ->setDescription('This is an audible description of any content present in the video, intended for users who can hear but are not able to see.'),
                LiteralField::create(
                    'DisplayShortcode',
                    '<div class="info message">Embed this video with [selfhostedvideo id="'.$this->ID.'"]</div>'
                )
            ]
        );

        return $fields;
    }
}
