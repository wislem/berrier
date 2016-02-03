<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Pages;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Wislem\Berrier\Http\Requests\StorePageRequest;
use Wislem\Berrier\Http\Requests\UpdatePageRequest;
use Wislem\Berrier\Models\Page;

class PageController extends Controller
{

    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('berrier::admin.pages.list');
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

//        $results = $this->page->search($searchPhrase);

        $results = $this->page->join('page_translations as t', 't.page_id', '=', 'page_id')->where('locale', '=', config('app.locale'));
        if($searchPhrase) {
            $results = $results->where('slug', 'like', '%' . $searchPhrase . '%')
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
            $rows[] = [
                'id' => $row->id,
                'slug' => $row->slug,
                'title' => $row->title,
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
        return view('berrier::admin.pages.create')->with('page', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePageRequest  $request
     * @return Response
     */
    public function store(StorePageRequest $request)
    {
        if($this->page->create($request->except('_token'))) {
            $msg = 'Page was created successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/pages')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->page->findOrFail($id);

        return view('berrier::admin.pages.edit')->with(compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePageRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdatePageRequest $request, $id)
    {
        $page = $this->page->findOrFail($id);

        $checkboxes = ['is_active'];
        foreach($checkboxes as $chk) {
            if(!$request->has($chk)) {
                $request->merge([$chk => 0]);
            }
        }

        if($page->update($request->except('_token'))) {
            $msg = 'Page was updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/pages')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $page = $this->page->findOrFail($id);

        if($page->delete()) {
            $msg = 'Page was deleted succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/pages')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
