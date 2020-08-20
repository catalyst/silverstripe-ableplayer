<video id="video1"
    data-able-player
    preload="auto"
    width="480"
    height="360"
    <% if Type == 'YouTube' %>data-youtube-id="$YouTubeID"<% end_if %>
    <% if Type == 'Vimeo' %>data-vimeo-id="$VimeoID"<% end_if %>
    <% if CaptionsTrackID %>playsinline<% end_if %>
    >
<%--  <source type="video/webm" src="path_to_video.webm" data-desc-src="path_to_described_video.webm"/>
  <source type="video/mp4" src="path_to_video.mp4" data-desc-src="path_to_described_video.mp4"/>

  <track kind="descriptions" src="path_to_descriptions.vtt"/>
--%>
    <% if CaptionsTrackID %>
    <track kind="captions" src="$CaptionsTrack.URL" srclang="$CaptionsTrackLang" label="$CaptionsTrackLabel"/>
    <% end_if %>
</video>
