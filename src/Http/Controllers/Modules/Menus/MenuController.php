<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Menus;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Wislem\Berrier\Http\Requests\MenuRequest;
use Wislem\Berrier\Models\Category;
use Wislem\Berrier\Models\Menu;
use Wislem\Berrier\Models\Page;

class MenuController extends Controller
{

    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('berrier::admin.menus.list');
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

//        $results = $this-menu->search($searchPhrase);

        if($searchPhrase) {
            $results = $this->menu->select('id', 'name', 'is_active', 'created_at', 'updated_at')
                ->where('id', 'like', '%' . $searchPhrase . '%')
                ->orWhere('name', 'like', '%' . $searchPhrase . '%');
        }else {
            $results = $this->menu->select('id', 'name', 'is_active', 'created_at', 'updated_at');
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
                'name' => $row->name,
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
        $pages = Page::active()->get();
        $categories = Category::withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();

        return view('berrier::admin.menus.create')
            ->with('menu', null)
            ->with(compact('pages'))
            ->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuRequest  $request
     * @return Response
     */
    public function store(MenuRequest $request)
    {
        if($this->menu->create($request->except('_token'))) {
            $msg = 'Menu was created successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/menus')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $menu = $this->menu->findOrFail($id);
        $pages = Page::active()->get();
        $categories = Category::withDepth()->defaultOrder()->descendantsOf(1)->linkNodes();

        return view('berrier::admin.menus.edit')
            ->with(compact('menu'))
            ->with(compact('pages'))
            ->with(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenuRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(MenuRequest $request, $id)
    {
        $menu = $this->menu->findOrFail($id);

        if($menu->update($request->except('_token'))) {
            $msg = 'Menu was updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/menus')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $menu = $this->menu->findOrFail($id);

        if($menu->delete()) {
            $msg = 'Menu was deleted succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/menus')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}