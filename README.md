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

TBC

## Contributions

Contributions are always welcome! Raise an issue and a pull request to start a discussion.

## Planned features / known issues
* Only Vimeo and YouTube are supported players at this time
* Not able to self-host videos yet
* Adding sign-language support is possible with self-hosted videos, but not YouTube
* Obtain auto-generated transcripts from YouTube videos
* Querying Title and other metadata from APIs

## Help needed

Shortcodes aren't great, and I would love to inject content automatically using TinyMCE. If you have an idea on how to do this, please raise and issue and a pull request. 
