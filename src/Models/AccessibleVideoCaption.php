<?php
namespace Catalyst\AblePlayer;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\i18n\Data\Intl\IntlLocales;
use SilverStripe\ORM\DataObject;

class AccessibleVideoCaption extends DataObject
{
    private static $table_name = 'AccessibleVideoCaption';
    private static $default_sort = 'Label ASC';
    private static $singular_name = 'Caption';
    private static $plural_name = 'Captions';


    private static $db = [
        'Label' => 'Varchar(80)',
        'Language' => 'Varchar(3)'
    ];

    private static $has_one = [
        'Track' => File::class,
        'Parent' => AccessibleVideo::class
    ];

    private static $owns = [
        'Track'
    ];


    private static $defaults = [
        'Language' => 'en'
    ];

    private static $summary_fields = [
        'Label',
        'Language',
        'Track.URL'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->addFieldsToTab(
            'Root.Main',
            [
                UploadField::create('Track', 'Captions Track')
                    ->setDescription('Web VTT file prepared for this video. This is written text shown underneath spoken words for users unable to hear. For more on this format, see <a href="https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format" target="_blank">this article</a>'),
                DropdownField::create(
                    'Language',
                    'Source Language'
                )->setSource(IntlLocales::config()->languages),
                TextField::create('Label', 'Label')
            ]
        );
        return $fields;
    }

    public function getTitle()
    {
        return $this->Label;
    }
}
