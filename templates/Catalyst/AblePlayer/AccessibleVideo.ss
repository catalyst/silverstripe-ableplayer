<video id="video1"
    data-able-player
    preload="auto"
    width="480"
    height="360"
    <% if Type == 'YouTube' %>data-youtube-id="$YouTubeID"<% end_if %>
    <% if Type == 'Vimeo' %>data-vimeo-id="$VimeoID"<% end_if %>
    <% if CaptionsTrackID %>playsinline<% end_if %>
    >

    <% if Captions.Count %>
    <% loop Captions %>
    <track kind="captions" src="$Track.URL" srclang="$Language" label="$Label"/>
    <% end_loop %>
    <% end_if %>
</video>
