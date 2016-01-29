<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Widgets;

use Wislem\Berrier\Http\Requests\WidgetRequest;
use Wislem\Berrier\Models\Page;
use Wislem\Berrier\Models\Widget;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use DB, Cache;

class WidgetController extends Controller
{

    protected $widget;

    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('berrier::admin.widgets.list');
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

        if($searchPhrase) {
            $results = $this->widget->select('id', 'title', 'path', 'position', 'is_active', 'is_global', 'ordr', 'created_at', 'updated_at')
                ->where('title', 'like', '%' . $searchPhrase . '%')
                ->orWhere('position', 'like', '%' . $searchPhrase . '%');
        }else {
            $results = $this->widget->select('id', 'title', 'path', 'position', 'is_active', 'is_global', 'ordr', 'created_at', 'updated_at');
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
                'title' => $row->title,
                'path' => $row->path,
                'position' => config('berrier.widget_positions.'.$row->position),
                'is_active' => $row->is_active,
                'is_global' => $row->is_global,
                'ordr' => $row->ordr
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $widget = null;
        $pages = Page::lists('title', 'id')->toArray();

        return view('berrier::admin.widgets.create')
            ->with(compact('pages'))
            ->with(compact('widget'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WidgetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WidgetRequest $request)
    {
        DB::beginTransaction();

        if($widget = $this->widget->create($request->except('_token', 'pages'))) {
            if($request->pages) {
                $widget->pages()->sync($request->pages);
            }

            DB::commit();
            $msg = 'Widget was created successfully';
            $msg_type = 'success';
        }else {
            DB::rollBack();
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/widgets')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = $this->widget->findOrFail($id);
        $pages = Page::lists('title', 'id')->toArray();

        return view('berrier::admin.widgets.edit')
            ->with(compact('pages'))
            ->with(compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WidgetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WidgetRequest $request, $id)
    {
        $widget = $this->widget->findOrFail($id);

        $checkboxes = ['is_active', 'is_global'];
        foreach($checkboxes as $chk) {
            if(!$request->has($chk)) {
                $request->merge([$chk => 0]);
            }
        }

        DB::beginTransaction();
        if($widget->update($request->except('_token'))) {
            if($request->pages) {
                $widget->pages()->sync($request->pages);
            }
            DB::commit();

            Cache::forget('widgets');
            $msg = 'Widget was updated successfully';
            $msg_type = 'success';
        }else {
            DB::rollBack();
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/widgets')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $widget = $this->widget->findOrFail($id);

        if($widget->delete()) {
            $msg = 'Widget was deleted succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/widgets')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
