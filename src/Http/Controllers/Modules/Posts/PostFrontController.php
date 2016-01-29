<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Posts;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Models\Post;

class PostFrontController extends Controller
{

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index($slug)
    {
        $post = $this->post->select('id', 'slug', 'title', 'content', 'meta_desc', 'media', 'categories')->active()->whereSlug($slug)->first();

        if(!$post) {
            App::abort(404);
        }

        $meta = [
            'title' => $post->title,
            'desc' => $post->meta_desc
        ];

        if(\View::exists('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)) {
            return view('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)
                ->with(compact('page'))
                ->with(compact('meta'));
        }

        return view('berrier::themes.' . config('berrier.theme.name') . '.post')
            ->with(compact('post'))
            ->with(compact('meta'));
    }

}