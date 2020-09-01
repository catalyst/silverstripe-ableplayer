<?php
namespace Catalyst\AblePlayer;

class YouTube extends AccessibleVideo
{
    /**
     * Extract the YouTube identifier from the record's URL
     *
     * @return mixed string identifier, or null if not a recognizable YouTube video
     */
    public function YouTubeID()
    {
        //https://stackoverflow.com/questions/42440678/regular-expression-for-youtube-video-id
        if(preg_match("#^(?:https?:)?//[^/]*(?:youtube(?:-nocookie)?\.com|youtu\.be).*[=/]([-\\w]{11})(?:\\?|=|&|$)#", $this->URL, $matches))
        {
            if(isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }
}
