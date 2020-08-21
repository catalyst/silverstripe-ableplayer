# Silverstripe AblePlayer

## Installation

```bash
composer require catalyst/silverstripe-ableplayer
```

## Usage

Usage is via shortcode in any HTMLTextField

[vimeo url=...]

[youtube url=...]

The URL is the same one you would visit on any desktop browser - simply copy and paste that. 

An accessible video record is retrieved from the CMS, or automatically created if it does not exist. You can add closed-captioning, audio descriptions, and chapter listings to these records for any ISO 639-3 (3 letter) language.

Note that not all videos are embeddable, as this is a setting controlled by the owner on Vimeo or YouTube. 

### VTT Formatting

The Able player uses Web Video Text Tracks (VTT) to display and speak text from a plain text file. This file can be loaded separately, or the text can be input directly in the CMS. The start and end times for each section *must* be in the following format. Line breaks are relevant, as are the `-->` and line breaks:
```
HH:MM:SS.### --> HH:MM:SS.###
Lorem ipsum dolem amit ...

HH:MM:SS.### --> HH:MM:SS.###
Lorem ipsum dolem amit ...

HH:MM:SS.### --> HH:MM:SS.###
Lorem ipsum dolem amit ...

```

More information on the format, and examples of its use, can be found on [the Wikipedia article](https://en.wikipedia.org/wiki/WebVTT#Example_of_WebVTT_format)

### Closed Captions
Closed captions are snippets of text that appear beneath the video to describe spoken words for users who are unable to hear them. The format supports very basic HTML (such as bold and italics) but should not be relied upon for cross-browser compatibility.

Closed caption VTT files look like this:
```
WEBVTT
kind: captions
lang: en

00:00:00.429 --> 00:00:09.165
[ music ]

00:00:09.165 --> 00:00:10.792
<v Narrator> You <i>want</i> these people.

00:00:10.792 --> 00:00:13.759
They <b>order</b> your products,
<b>sign up</b> for your services,

00:00:13.759 --> 00:00:16.627
<b>enroll</b> in your classes,
<b>read</b> your opinions,

00:00:16.627 --> 00:00:18.561
and <b>watch</b> your videos.

00:00:18.561 --> 00:00:24.165
You'll never see them, but they know you-
through your website.
```

If entering in the CMS, you only need to enter the timestamp and description information. The first four lines (WEBVTT, kind, lang, followed by whitespace) will automatically generated and should be omitted.

### Audio descriptions
Audio descriptions are used to describe parts of the video that contain words that are not spoken aloud. These are useful to users who are unable to see the video but can listen in.

Audio description VTT files look like this:
```
WEBVTT

00:00:00.005 --> 00:00:06.000
Ein blauer Kreis mit Kreissegmenten im Innern,
darunter "DO-IT" (Deutsch: "tu es")

00:00:06.000 --> 00:00:12.000
Wörter erscheinen in einem weissen Rahmen:
World Wide Access (Deutsch: weltweiter Zugang).

00:00:37.100 --> 00:00:47.000
Terrill Thompson,
Spezialist für barrierefreie Technologien
```

If entering in the CMS, you only need to enter the timestamp and description information. The first two lines (WEBVTT followed by whitespace) will automatically generated and should be omitted.

### Chapter listings
Chapter listings are used to logically break the video up into easy to navigate sections. These allow the user to skip ahead to parts of the video they want to watch.

Chapter listing VTT files look like this:
```
WEBVTT

Chapter 1
00:00:00.000 --> 00:00:37.000
Intro

Chapter 2
00:00:37.000 --> 00:01:00.000
Terrill Thompson
```

If entering in the CMS, you need to enter the "Chapter \<number\>, followed by timestamps, followed by the name of the section.  The first two lines (WEBVTT followed by whitespace) will automatically generated and should be omitted.

## Configuration

### VTT Content Controller
Behind the scenes, the module will call a barebones controller to serve CMS-generated WebVTT content in a manner that the Able player can use. This controller has a configurable url_segment and a route that is automatically loaded to ensure conflicts with a published page are unlikely. This settings can be changed using Silverstripe's Config API

```yml
Catalyst\AblePlayer\AccessibleVideoController:
  url_segment: "__video"

SilverStripe\Control\Director:
  rules:
    '__video': Catalyst\AblePlayer\AccessibleVideoController

Catalyst\AblePlayer\AccessibleVideoAudioDescription:
  audiodescription_controller_link: "__video/audiodescription"
Catalyst\AblePlayer\AccessibleVideoCaption:
  transcript_controller_link: "__video/transcript"
Catalyst\AblePlayer\AccessibleVideoChapters:
  chapters_controller_link: "__video/chapters"
```

This controller serves three methods: `transcript`, `audiodescription`, and `chapters`, and each one is called like this: `https://yoursite/__video/transcript/$ID`, where $ID is the CMS record ID containing your VTT text. The names of these methods are hardcoded and cannot be changed; however, you can probably define your own using different names using an extension (this is untested).

### Shortcode Frontend
The Able player requires a version of JQuery greater than 3.2.1 and will load it automatically if the vimeo or youtube shortcodes are rendered on the page. If you are not using JQuery on your site this should be an issue, but if you have a conflicting version that is otherwise compatible with the player, you can instruct the parser to load a different version directly from the CDN.

You can also redefine the location of the Vimeo Javascript player, which is required to view Vimeo-hosted videos. 

```yml
Catalyst\AblePlayer\AccessibleVideoShortcodeProvider:
  jquery_version: "3.2.1"
  vimeo_player_url: "https://player.vimeo.com/api/player.js"
```

## Contributions

Contributions are always welcome! Raise an issue and a pull request to start a discussion.

## Planned features and known issues
* Only Vimeo and YouTube are supported players at this time
* Not able to self-host videos yet
* Adding sign-language support is possible with self-hosted videos, but not YouTube
* Obtain auto-generated transcripts from YouTube videos
* Querying Title and other metadata from APIs
* The "first" chapter defined in the CMS is the default. The list should be sortable or otherwise configurable in the CMS
* Audio is not supported yet

## Help needed

Shortcodes aren't great, and I would love to inject content automatically using TinyMCE. If you have an idea on how to do this, please raise an issue and create a pull request. 
