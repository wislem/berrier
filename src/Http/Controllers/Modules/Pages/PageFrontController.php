<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Pages;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Http\Controllers\Modules\Widgets\Facades\Widget;
use Wislem\Berrier\Models\Page;

class PageFrontController extends Controller
{

    protected $object;

    public function __construct(Page $object)
    {
        $this->object = $object;
    }

    public function index($slug)
    {
        $object = $this->object->join('page_translations as t', 't.page_id', '=', 'pages.id')
            ->select('id', 'slug', 'title', 'content', 'meta_desc')->active()->whereSlug($slug)->first();

        if(!$object) {
            \App::abort(404);
        }

        $meta = [
            'title' => $object->title,
            'desc' => $object->meta_desc
        ];

        $object->content = str_replace('{{url}}', \Request::url(), $object->content);
        $widgets = Widget::extract_unit($object->content, '{{', '}}');
        foreach($widgets as $bbcode => $widget) {
            $object->content = str_replace('{{' . $bbcode . '}}', $widget, $object->content);
        }

        if(\View::exists('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)) {
            return view('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)
                ->with(compact('object'))
                ->with(compact('meta'));
        }

        return view('berrier::themes.' . config('berrier.theme.name') . '.page')
            ->with(compact('object'))
            ->with(compact('meta'));
    }

}