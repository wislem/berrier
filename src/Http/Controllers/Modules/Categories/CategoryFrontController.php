<?php
namespace Wislem\Berrier\Http\Controllers\Modules\Categories;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Models\Category;

class CategoryFrontController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index($slug = '')
    {
        $category = $this->category->join('category_translations as t', 't.category_id', '=', 'categories id')
            ->whereSlug($slug)->first();

        $meta = [
            'title' => $category->name,
            'desc' => $category->name
        ];

        if(!$category) {
            \App::abort(404);
        }

        $posts = Post::whereHas('categories', function($q) use ($category) {
            $q->whereIn('id', $category->getChildren()->pluck('id')->toArray());
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