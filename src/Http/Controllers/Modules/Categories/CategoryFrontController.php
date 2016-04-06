<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Categories;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Models\Category;

class CategoryFrontController extends Controller
{
    protected $object;

    public function __construct(Category $object)
    {
        $this->object = $object;
    }

    public function index($slug = '')
    {
        $object = $this->object->join('category_translations as t', 't.category_id', '=', 'categories id')
            ->whereSlug($slug)->first();

        $meta = [
            'title' => $object->name,
            'desc' => $object->name
        ];

        if(!$object) {
            \App::abort(404);
        }

        $posts = Post::whereHas('categories', function($q) use ($object) {
            $q->whereIn('id', $object->getChildren()->pluck('id')->toArray());
        })->active()->orderBy('updated_at', 'DESC')->paginate(12);

        if(\View::exists('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)) {
            return view('berrier::themes.' . config('berrier.theme.name') . '.custom.' . $slug)
                ->with(compact('page'))
                ->with(compact('meta'));
        }

        return view('berrier::themes.' . config('berrier.theme.name') . '.category')
            ->with(compact('category'))
            ->with(compact('meta'))
            ->with(compact('posts'));
    }

}
