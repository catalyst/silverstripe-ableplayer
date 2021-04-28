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

class AccessibleVideoChapters extends DataObject
{
    private static $table_name = 'AccessibleVideoChapters';
    private static $singular_name = 'Chapters';
    private static $plural_name = 'Chapter Lists';


    private static $db = [
        'Language' => 'Varchar(3)',
        'Chapters' => 'Text',
        'Title' => 'Varchar(64)'
    ];

    private static $has_one = [
        'Track' => File::class,
        'Parent' => AccessibleVideo::class
    ];

    private static $owns = [
        'Track'
    ];


    private static $defaults = [
        'Title' => 'Table of Contents',
        'Language' => 'en'
    ];

    private static $summary_fields = [
        'Title',
        'Language',
        'getTrackURL' => 'Track URL'
    ];

    private static $chapters_controller_link = '__video/chapters';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['ParentID', 'Chapters', 'Track']);
        $fields->addFieldsToTab(
            'Root.Main',
            [
                TextField::create('Title', 'Title'),
                DropdownField::create(
                    'Language',
                    'Source Language'
                )->setSource(IntlLocales::config()->languages),
                ToggleCompositeField::create(
                    'ChapterToggle',
                    'Chapters',
                    [
                        UploadField::create('Track', 'Chapters Track')
                            ->setDescription('Web VTT file prepared for this video. This breaks the video up into distinct sections for users to skip to. For more on this format, see <a href="https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format" target="_blank">this article</a>'),
                        TextareaField::create('Chapters', 'Chapters')
                            ->setDescription(
                                'If an existing chapters (VTT file) are not available, you can manually create one here.'
                                .'This format is plain text, but basic HTML (such as bold and italics) can be used sparingly.'
                            )->setAttribute(
                                'placeholder',
'Chapter 1
00:00:00.429 --> 00:00:09.165
Lorem ipsum dolor sit amet

Chapter 2
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
     * If a VTT file is not uploaded, this url is used to load content from the CMS
     *
     * @return string
     */
    public function ChaptersLink()
    {
        return $this->config()->chapters_controller_link . '/' . $this->ID;
    }

    /**
     * Returns the Track URL of an uploaded file, or a link to CMS-driven content
     *
     * @return DBField
     */
    public function getTrackURL()
    {
        $html = $this->ChaptersLink();
        if($this->TrackID) {
            return $this->Track()->URL;
        }

        return DBField::create_field('HTMLText', $html);
    }
}
