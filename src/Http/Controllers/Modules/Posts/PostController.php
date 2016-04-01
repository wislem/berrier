<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Posts;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Wislem\Berrier\Http\Requests\StorePostRequest;
use Wislem\Berrier\Http\Requests\UpdatePostRequest;
use Wislem\Berrier\Models\Category;
use Wislem\Berrier\Models\Media;
use Wislem\Berrier\Models\Post;

class PostController extends Controller
{

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('berrier::admin.posts.list');
    }

    /**
     * Return grid data
     *
     * @param $request \Illuminate\Http\Request
     * @return Response
     */
    public function grid(Request $request)
    {
        $take = ($request->has('rowCount')) ? $request->get('rowCount') : 10;
        $skip = $request->get('current') - 1;
        $searchPhrase = ($request->has('searchPhrase')) ? $request->get('searchPhrase') : '';
        $sort = ($request->has('sort')) ? $request->get('sort') : false;

//        $results = $this->post->search($searchPhrase);

        $results = $this->post->join('post_translations as t', 't.post_id', '=', 'post_id')->where('locale', '=', config('app.locale'))->groupBy('pages.id')->with('translations');

        if($searchPhrase) {
            $results = $results->with('categories')
                ->where('slug', 'like', '%' . $searchPhrase . '%')
                ->orWhere('title', 'like', '%' . $searchPhrase . '%')
                ->orWhere('content', 'like', '%' . $searchPhrase . '%');
        }

        $count_results = $results->count();
        $results = $results->take($take)->skip($take * $skip);


        if(is_array($sort)) {
            $results = $results->orderBy(key($sort), $sort[key($sort)]);
        }

        $results = $results->get();

        $rows = [];

        foreach($results as $row) {
            $categories = '';
            foreach($row->categories->pluck('name') as $category) {
                $categories .= '<span class="label label-primary">' . $category . '</span>';
            }
            $rows[] = [
                'id' => $row->id,
                'slug' => $row->slug,
                'title' => $row->title,
                'categories' => $categories,
                'is_active' => $row->is_active
            ];
        }

        $data = array(
            'current' => (int) $request->get('current'),
            'rowCount' => $take,
            'rows' => $rows,
            'total' => $count_results,
        );

        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories_tree = Category::withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();
        $categories = renderTreeToOptions($categories_tree);

        return view('berrier::admin.posts.create')
            ->with('post', null)
            ->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @return Response
     */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        if($post = $this->post->create($request->except('_token'))) {
            // Associate already created media with new item
            if($request->has('media')) {
                // and save new ones
                foreach($request->media as $index => $req_medium) {
                    $tmp = Media::wherePath($req_medium)->first();
                    $tmp->ordr = $index;
                    $tmp->save();
                    $media[] = $tmp;
                }
                $post->media()->saveMany($media);
            }

            $post->categories()->sync($request->categories);

            $msg = 'Post was created successfully';
            $msg_type = 'success';

            DB::commit();
        }else {
            DB::rollBack();
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/posts')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->post->with('categories', 'media')->findOrFail($id);
        $categories_tree = Category::withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();
        $categories = renderTreeToOptions($categories_tree);

        return view('berrier::admin.posts.edit')
            ->with(compact('post'))
            ->with(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->post->findOrFail($id);

        $checkboxes = ['is_active'];
        foreach($checkboxes as $chk) {
            if(!$request->has($chk)) {
                $request->merge([$chk => 0]);
            }
        }

        if($post->update($request->except('_token', 'media'))) {
            if($request->has('media')) {
                // Delete old ones except the ones kept ;)
                $old_media = $post->media()->whereNotIn('path', $request->media)->get();
                foreach($old_media as $medium) {
                    $medium->delete();
                }
                // and save new ones
                foreach($request->media as $index => $req_medium) {
                    $tmp = Media::wherePath($req_medium)->first();
                    $tmp->ordr = $index;
                    $tmp->save();
                    $media[] = $tmp;
                }
                $post->media()->saveMany($media);
            }

            $post->categories()->sync($request->categories);

            $msg = 'Post was updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/posts')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);

        if($post->delete()) {
            $msg = 'Post was deleted succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/posts')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
