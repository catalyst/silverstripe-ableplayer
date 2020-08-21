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

class AccessibleVideoCaption extends DataObject
{
    private static $table_name = 'AccessibleVideoCaption';
    private static $default_sort = 'Label ASC';
    private static $singular_name = 'Caption';
    private static $plural_name = 'Captions';


    private static $db = [
        'Label' => 'Varchar(80)',
        'Language' => 'Varchar(3)',
        'Transcript' => 'Text'
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
        'getTrackURL' => 'Track URL'
    ];

    private static $transcript_controller_link = '__video/transcript';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['ParentID', 'Transcript', 'Track']);
        $fields->addFieldsToTab(
            'Root.Main',
            [
                DropdownField::create(
                    'Language',
                    'Source Language'
                )->setSource(IntlLocales::config()->languages),
                TextField::create('Label', 'Label'),
                ToggleCompositeField::create(
                    'TranscriptToggle',
                    'Transcript',
                    [
                        UploadField::create('Track', 'Captions Track')
                            ->setDescription('Web VTT file prepared for this video. This is written text shown underneath spoken words for users unable to hear. For more on this format, see <a href="https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format" target="_blank">this article</a>'),
                        TextareaField::create('Transcript', 'Transcript')
                            ->setDescription(
                                'If an existing transcript (VTT file) is not available, you can manually create one here.'
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
     * Transcripts don't have titles, so use the label in the CMS heading instead
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->Label;
    }

    /**
     * If a VTT file is not uploaded, this url is used to load content from the CMS
     *
     * @return string
     */
    public function TranscriptLink()
    {
        return $this->config()->transcript_controller_link . '/' . $this->ID;
    }

    /**
     * Returns the Track URL of an uploaded file, or a link to CMS-driven content
     *
     * @return DBField
     */
    public function getTrackURL()
    {
        $html = $this->TranscriptLink();
        if($this->TrackID) {
            return $this->Track()->URL;
        }

        return DBField::create_field('HTMLText', $html);
    }
}
