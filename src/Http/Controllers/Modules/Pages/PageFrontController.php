<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Pages;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Http\Controllers\Modules\Widgets\Facades\Widget;
use Wislem\Berrier\Models\Page;

class PageFrontController extends Controller
{

    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index($slug)
    {
        $page = $this->page->join('page_translations as t', 't.page_id', '=', 'pages.id')
            ->select('pages.id', 'slug', 'title', 'content', 'meta_desc')->active()->whereSlug($slug)->first();

        if(!$page) {
            App::abort(404);
        }

        $meta = [
            'title' => $page->title,
            'desc' => $page->meta_desc
        ];

        $page->content = str_replace('{{url}}', \Request::url(), $page->content);
        $widgets = Widget::extract_unit($page->content, '{{', '}}');
        foreach($widgets as $bbcode => $widget) {
            $page->content = str_replace('{{' . $bbcode . '}}', $widget, $page->content);
        }

        if(\View::exists('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)) {
            return view('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)
                ->with(compact('page'))
                ->with(compact('meta'));
        }

        return view('berrier::themes.' . config('berrier.theme.name') . '.page')
            ->with(compact('page'))
            ->with(compact('meta'));
    }

}