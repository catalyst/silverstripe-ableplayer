<video id="video1"
    data-able-player
    preload="auto"
    width="480"
    height="360"
    <% if Type == 'YouTube' %>data-youtube-id="$YouTubeID"<% end_if %>
    <% if Type == 'Vimeo' %>data-vimeo-id="$VimeoID"<% end_if %>
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
</video>
