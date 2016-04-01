<?php

namespace Wislem\Berrier\Http\Controllers\Modules\UserSettings;

use Wislem\Berrier\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Wislem\Berrier\Models\UserSetting;

class UserSettingController extends Controller
{
    protected $setting;

    public function __construct(UserSetting $setting)
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
        return view('berrier::admin.usettings.list');
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
            $results = $this->setting->select('id', 'name', 'key', 'default', 'user_editable', 'created_at', 'updated_at')
                ->where('name', 'like', '%' . $searchPhrase . '%')
                ->orWhere('key', 'like', '%' . $searchPhrase . '%');
        }else {
            $results = $this->setting->select('id', 'name', 'key', 'default', 'user_editable', 'created_at', 'updated_at');
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
                'default' => $row->default,
                'user_editable' => $row->user_editable
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
        return view('berrier::admin.usettings.create')->with('setting', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreUserSettingRequest $request
     * @return Response
     */
    public function store(Requests\StoreUserSettingRequest $request)
    {
        if($this->setting->create($request->all())) {
            $msg = 'Setting was created succesfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/usettings')->with('msg', $msg)->with('msg_type', $msg_type);
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

        return view('berrier::admin.usettings.edit')->with(compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\UpdateUserSettingRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Requests\UpdateUserSettingRequest $request, $id)
    {
        $setting = $this->setting->findOrFail($id);

        if($setting->update($request->all())) {
            $msg = 'Setting updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('berrier::admin/usettings')->with('msg', $msg)->with('msg_type', $msg_type);
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

        return redirect('berrier::admin/usettings')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
