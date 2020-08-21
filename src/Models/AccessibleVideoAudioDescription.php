<?php
namespace Catalyst\AblePlayer;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\i18n\Data\Intl\IntlLocales;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;

class AccessibleVideoAudioDescription extends DataObject
{
    private static $table_name = 'AccessibleVideoAudioDescription';
    private static $default_sort = 'Label ASC';
    private static $singular_name = 'Caption';
    private static $plural_name = 'Captions';


    private static $db = [
        'Language' => 'Varchar(3)',
        'AudioDescription' => 'Text'
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
        'Language',
        'getTrackURL' => 'Track URL'
    ];

    private static $audiodescription_controller_link = '__video/audiodescription';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['ParentID', 'AudioDescription', 'Track']);
        $fields->addFieldsToTab(
            'Root.Main',
            [
                DropdownField::create(
                    'Language',
                    'Source Language'
                )->setSource(IntlLocales::config()->languages),
                ToggleCompositeField::create(
                    'AudioDescriptionToggle',
                    'Audio Description',
                    [
                        UploadField::create('Track', 'Captions Track')
                            ->setDescription('Web VTT file prepared for this video. This is written text describing the scene for users unable to see. For more on this format, see <a href="https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format" target="_blank">this article</a>'),
                        TextareaField::create('AudioDescription', 'Audio Description')
                            ->setDescription(
                                'If an existing audio description (VTT file) is not available, you can manually create one here.'
                                .'This format is plain text, but basic HTML (such as bold and italics) can be used sparingly.'
                            )->setAttribute(
                                'placeholder',
'00:00:00.429 --> 00:00:09.165
Lorem ipsum dolor sit amet

00:00:09.165 --> 00:00:10.792
<v Narrator> Et <i>tu</i>, Bruta?

'
                            )
                    ]
                )
            ]
        );
        return $fields;
    }

    /**
     * Audio descriptions don't have titles, so display the Language in the CMS heading
     *
     * @return string
     */
    public function getTitle()
    {
        if($this->Language) {
            return IntlLocales::config()->languages[$this->Language] ?? $this->Language;
        }
    }

    /**
     * If a VTT file is not uploaded, this url is used to load content from the CMS
     *
     * @return string
     */
    public function AudioDescriptionLink()
    {
        return $this->config()->audiodescription_controller_link . '/' . $this->ID;
    }

    /**
     * Returns the Track URL of an uploaded file, or a link to CMS-driven content
     *
     * @return DBField
     */
    public function getTrackURL()
    {
        $html = $this->AudioDescriptionLink();
        if($this->TrackID) {
            return $this->Track()->URL;
        }

        return DBField::create_field('HTMLText', $html);
    }
}
