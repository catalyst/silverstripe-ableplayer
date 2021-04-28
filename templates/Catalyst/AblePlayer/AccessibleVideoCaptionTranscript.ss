WEBVTT

<% if Transcript %>
kind: captions
lang: $Language
$Transcript.RAW
<% end_if %>

<% if AudioDescription %>
$AudioDescription.RAW
<% end_if %>
