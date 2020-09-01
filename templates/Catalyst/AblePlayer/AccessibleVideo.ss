<% if $YouTubeID || $VimeoID %>
<% if Chapters %>
<div id="chapters-$YouTubeID$VimeoID"></div>
<% end_if %>
<video id="video1"
    data-able-player
    data-skin="2020"
    preload="auto"
    width="480"
    height="360"
    <% if Chapters %>
    data-chapters-div="chapters-$YouTubeID$VimeoID"
    data-use-chapters-button="true"
    data-chapters-title="$Chapters.First.Title"
    data-prevnext-unit="chapter"
    <% end_if %>
    <% if $YouTubeID %>data-youtube-id="$YouTubeID"<% end_if %>
    <% if $VimeoID %>data-vimeo-id="$VimeoID"<% end_if %>
    <% if CaptionsTrackID || Transcript %>playsinline<% end_if %>
    >

    <% if Captions.Count %>
    <% loop Captions %>
    <% if $Track %>
        <track kind="captions" src="$Track.URL" srclang="$Language" label="$Label"/>
    <% else_if $Transcript %>
        <track kind="captions" src="$TranscriptLink" srclang="$Language" label="$Label"/>
    <% end_if %>
    <% end_loop %>
    <% end_if %>

    <% if AudioDescriptions.Count %>
    <% loop AudioDescriptions %>
    <% if $Track %>
        <track kind="descriptions" src="$Track.URL" srclang="$Language"/>
    <% else_if $AudioDescription %>
        <track kind="descriptions" src="$AudioDescriptionLink" srclang="$Language"/>
    <% end_if %>
    <% end_loop %>
    <% end_if %>

    <% if Chapters.Count %>
    <% loop Chapters %>
        <% if Track %>
        <track kind="chapters" src="$Track.URL" srclang="$Language" />
        <% else_if $Chapters %>
        <track kind="chapters" src="$ChaptersLink" srclang="$Language" />
        <% end_if %>
    <% end_loop %>
    <% end_if %>
</video>

<% end_if %>
