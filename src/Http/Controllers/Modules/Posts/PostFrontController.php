<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Posts;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Models\Post;

class PostFrontController extends Controller
{

    protected $object;

    public function __construct(Post $object)
    {
        $this->object = $object;
    }

    public function index($slug)
    {
        $object = $this->object->select('id', 'slug', 'title', 'content', 'meta_desc', 'media', 'categories')->active()->whereSlug($slug)->first();

        if(!$object) {
            App::abort(404);
        }

        $meta = [
            'title' => $object->title,
            'desc' => $object->meta_desc
        ];

        if(\View::exists('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)) {
            return view('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)
                ->with(compact('object'))
                ->with(compact('meta'));
        }

        return view('berrier::themes.' . config('berrier.theme.name') . '.post')
            ->with(compact('object'))
            ->with(compact('meta'));
    }

}
