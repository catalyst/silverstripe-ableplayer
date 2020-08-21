<?php
namespace Catalyst\AblePlayer;

use SilverStripe\Control\Controller;
use SilverStripe\View\SSViewer;

class AccessibleVideoController extends Controller
{
    private static $url_segment = '__video';
    private static $allowed_actions = [
        'transcript',
        'audiodescription',
        'chapters'
    ];

    public function transcript($request)
    {
        $id = (int) $request->param('ID');

        if ($id && $record = AccessibleVideoCaption::get()->byID($id)) {
            $this->response->addHeader('content-type', 'text/vtt');
            return SSViewer::execute_template(
                'Catalyst/AblePlayer/AccessibleVideoCaptionTranscript',
                $record
            );
        }
    }

    public function audiodescription($request)
    {
        $id = (int) $request->param('ID');

        if ($id && $record = AccessibleVideoAudioDescription::get()->byID($id)) {
            $this->response->addHeader('content-type', 'text/vtt');
            return SSViewer::execute_template(
                'Catalyst/AblePlayer/AccessibleVideoCaptionTranscript',
                $record
            );
        }
    }

    public function chapters($request)
    {
        $id = (int) $request->param('ID');

        if ($id && $record = AccessibleVideoChapters::get()->byID($id)) {
            $this->response->addHeader('content-type', 'text/vtt');
            return SSViewer::execute_template(
                'Catalyst/AblePlayer/AccessibleVideoChapters',
                $record
            );
        }
    }
}
