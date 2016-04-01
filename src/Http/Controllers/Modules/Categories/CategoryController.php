<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Categories;

use Illuminate\Http\Request;
use Wislem\Berrier\Http\Requests\StoreCategoryRequest;
use Wislem\Berrier\Http\Requests\UpdateCategoryRequest;
use Wislem\Berrier\Models\Category;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::toJqTree();

        return view('berrier::admin.categories.list')->with(compact('categories'));
    }

    public function create()
    {
        $categories_tree = Category::join('category_translations as t', 't.category_id', '=', 'categories.id')
            ->where('locale', '=', config('app.locale'))
            ->withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();

        $categories = [];
        foreach($categories_tree as $category) {
            $name = '';
            for($i = 1; $i < $category->depth; $i++) {
                $name .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $name .= '-';
            $categories[$category->id] = $name . ' ' . $category->name;
        }

        return view('berrier::admin.categories.create')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $response = ['error' => 0, 'msg' => '', 'name' => '', 'id' => 0, 'parent_id' => 0];

        DB::beginTransaction();

        $sourceCategory = Category::create($request->all());
        $targetCategory = ($request->has('parent_id')) ? Category::findOrFail($request->parent_id) : Category::root();

        // append category to root
        if ( $status = $sourceCategory->appendToNode($targetCategory)->save() ) {
            Category::fixTree();
            DB::commit();
            $response['msg'] = 'Saved successfully';
            $response['name'] = $sourceCategory->name;
            $response['id'] = $sourceCategory->id;
            $response['parent_id'] = $sourceCategory->parent_id;
        }

        if (!isset($status) || $status == null) {
            DB::rollback();
            $response['error'] = 1;
            $response['msg'] = 'Something went wrong';
            return response($response, 400);
        }

        return response($response);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $categories_tree = Category::join('category_translations as t', 't.category_id', '=', 'categories.id')
            ->where('locale', '=', config('app.locale'))
            ->withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();

        $categories = [];
        foreach($categories_tree as $cat) {
            $name = '';
            for($i = 1; $i < $cat->depth; $i++) {
                $name .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $name .= '-';
            $categories[$cat->id] = $name . ' ' . $cat->name;
        }

        return view('berrier::admin.categories.edit')
            ->with(compact('category'))
            ->with(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $response = ['error' => 0, 'msg' => '', 'name' => '', 'id' => 0, 'parent_id' => 0];

        DB::beginTransaction();

        $category = Category::findOrFail($id);
        $target =
        $status = $category->update($request->all());

        if($status) {
            if(Category::isBroken()) {
                Category::fixTree();
            }
            DB::commit();
        }else {
            DB::rollback();
        }

        return redirect('admin/categories');
    }

    /**
     * Move the selected category inside the tree
     *
     * @param  Request  $request
     * @return Response
     */
    public function move(Request $request, $id)
    {
        $response = ['error' => 0, 'msg' => '', 'name' => '', 'id' => '', 'parent_id' => 0];

        // get source/target categories from DB
        $sourceCategory = Category::find($id);
        $targetCategory = Category::find($request->to);
        // check for data consistency (can also do a try&catch instead)
        if ($sourceCategory and $targetCategory and ($sourceCategory->parent_id == $request->parent_id)) {
            switch ($request->direction) {
                case "inside" :
                    $status = $sourceCategory->prependToNode($targetCategory)->save();
                    break;
                case "before" :
                    $status = $sourceCategory->beforeNode($targetCategory)->save();
                    break;
                case "after" :
                    $status = $sourceCategory->afterNode($targetCategory)->save();
                    break;
            }

            if ($status) {
                if(Category::isBroken()) {
                    Category::fixTree();
                }
                DB::commit();
                $response['msg'] = 'Moved successfully';
                $response['name'] = $request->name;
                $response['id'] = $sourceCategory->id;
                $response['parent_id'] = $sourceCategory->parent_id;
            }else {
                DB::rollback();
                $response['error'] = 1;
                $response['msg'] = 'Something went wrong.';
            }
        }

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = ['error' => 0, 'msg' => ''];

        if($id == 1) {
            return redirect('admin/categories')->withErrors(['general' => 'Didn\'t I say, DO NOT DELETE THE ROOT CATEGORY?????']);
        }

        try {
            $category = Category::findOrFail($id);
            $category->delete();

            if(Category::isBroken()) {
                Category::fixTree();
            }
        } catch (\Exception $e) {
            return redirect('admin/categories')->withErrors(['general' => 'Something went wrong: ' . $e->getMessage()]);
        }

        return redirect('admin/categories')->with('success', 'Category deleted successfully');
    }
}
