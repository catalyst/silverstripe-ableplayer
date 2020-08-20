<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Control\Controller;
use SilverStripe\View\SSViewer;

class AccessibleVideoController extends Controller
{
    private static $url_segment = '__video';
    private static $allowed_actions = [
        'transcript'
    ];

    public function transcript($request)
    {
        $id = (int) $request->param('ID');

        if ($id && $record = AccessibleVideoCaption::get()->byID($id)) {
            $this->response->addHeader('content-type', 'text/vtt');
            return sprintf(
                "WEBVTT\n"
                ."kind: captions\n"
                ."lang: %s\n"
                ."\n"
                ."%s\n ",
                $record->Language,
                $record->Transcript
            );
        }
    }
}
