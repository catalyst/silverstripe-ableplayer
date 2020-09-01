<?php
namespace Catalyst\AblePlayer;

use SilverStripe\ORM\DataObject;

class AccessibleVideo extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'URL' => 'Varchar(255)',
    ];

    private static $has_many = [
        'Captions' => AccessibleVideoCaption::class,
        'AudioDescriptions' => AccessibleVideoAudioDescription::class,
        'Chapters' => AccessibleVideoChapters::class
    ];

    private static $table_name = 'AccessibleVideo';
    private static $default_sort = 'Title ASC';
    private static $singular_name = 'Video';
    private static $plural_name = 'Videos';

    private static $summary_fields = [
        'URL' => "Link",
        'Title' => "Title",
        'Captions.Count' => 'Caption tracks',
        'AudioDescriptions.Count' => 'Audio descriptions',
        'Chapters.Count' => 'Chapters'
    ];
}
