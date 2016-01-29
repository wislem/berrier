<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Settings;

use Wislem\Berrier\Http\Requests\StoreSettingRequest;
use Wislem\Berrier\Http\Requests\UpdateSettingRequest;
use Wislem\Berrier\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('berrier::admin.settings.list');
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

        if($searchPhrase) {
            $results = $this->setting->select('id', 'name', 'key', 'value', 'created_at', 'updated_at')
                ->where('name', 'like', '%' . $searchPhrase . '%')
                ->orWhere('key', 'like', '%' . $searchPhrase . '%')
                ->orWhere('value', 'like', '%' . $searchPhrase . '%');
        }else {
            $results = $this->setting->select('id', 'name', 'key', 'value', 'created_at', 'updated_at');
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
                'key' => $row->key,
                'value' => $row->value
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
        return view('berrier::admin.settings.create')->with('setting', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSettingRequest $request
     * @return Response
     */
    public function store(StoreSettingRequest $request)
    {
        if($this->setting->create($request->except('_token'))) {
            $msg = 'Setting was created succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/settings')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $setting = $this->setting->findOrFail($id);

        return view('berrier::admin.settings.edit')->with(compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSettingRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateSettingRequest $request, $id)
    {
        $setting = $this->setting->findOrFail($id);

        if($setting->update($request->except('_token'))) {
            $msg = 'Setting updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/settings')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $setting = $this->setting->findOrFail($id);
        if($setting->delete()) {
            $msg = 'Setting deleted successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/settings')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
