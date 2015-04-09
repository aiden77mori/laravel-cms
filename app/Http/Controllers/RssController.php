<?php namespace Fully\Http\Controllers;

use Fully\Models\News;
use Fully\Feeder\Facade\Feeder;
use Response;

/**
 * Class RssController
 * @author Sefa Karagöz
 */
class RssController extends Controller {

    public function index() {

        $items = News::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $data = array();
        foreach ($items as $k => $v) {
            $data[] = array('title' => $v->title, 'description' => $v->content, 'link' => url($v->url));
        }

        $feed = Feeder::feed($data);
        return Response::make($feed, 200, array('Content-Type' => 'text/xml'));
    }
}
