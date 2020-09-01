<?php
namespace Catalyst\AblePlayer;

class Vimeo extends AccessibleVideo
{
    /**
     * Extract the Vimeo identifier from the record's URL
     *
     * @return mixed string identifier, or null if not a recognizable Vimeo video
     */
    public function VimeoID()
    {
        if(preg_match("#(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)#", $this->URL, $matches))
        {
            if(isset($matches[4])) {
                return $matches[4];
            }
        }

        return null;

    }
}
