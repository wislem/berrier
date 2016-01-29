<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Users;

use Wislem\Berrier\Http\Requests\StoreUserRequest;
use Wislem\Berrier\Http\Requests\UpdateUserRequest;
use Wislem\Berrier\Models\User;
use Wislem\Berrier\Models\UserSetting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('berrier::admin.users.list');
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

//        $results = $this->user->search($searchPhrase);

        if($searchPhrase) {
            $results = $this->user->select('id', 'email', 'role', 'status', 'last_login', 'created_at', 'updated_at')
                ->where('first_name', 'like', '%' . $searchPhrase . '%')
                ->orWhere('last_name', 'like', '%' . $searchPhrase . '%')
                ->orWhere('email', 'like', '%' . $searchPhrase . '%')
                ->orWhere('p_title', 'like', '%' . $searchPhrase . '%')
                ->orWhere('landline', 'like', '%' . $searchPhrase . '%')
                ->orWhere('mobile', 'like', '%' . $searchPhrase . '%');
        }else {
            $results = $this->user->select('id', 'email', 'role', 'status', 'last_login', 'created_at', 'updated_at');
        }

        $count_results = $results->count();
        $results = $results->take($take)->skip($take * $skip);

        if(is_array($sort)) {
            if(key($sort) == 'state') {
                $results = $results->orderBy('status', $sort[key($sort)]);
            }else {
                $results = $results->orderBy(key($sort), $sort[key($sort)]);
            }
        }

        $results = $results->get();

        $rows = [];

        foreach($results as $row) {
            $rows[] = [
                'id' => $row->id,
                'email' => $row->email,
                'role' => $row->role,
                'state' => $row->status,
                'last_login' => (!empty($row->last_login)) ? $row->last_login->format('d-m-Y') : '---',
                'created_at' => $row->created_at->format('d-m-Y')
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
        $user = null;
        $settings = UserSetting::select('id', 'name', 'key', 'default')->orderBy('key', 'DESC')->get();

        return view('berrier::admin.users.create')->with(compact('user'))->with(compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $request->merge(['last_login' => ($request->last_login) ? $request->last_login : null]);

        if($user = $this->user->create($request->except(['_token', 'settings']))) {
            if($request->has('settings')) {
                $user_settings = [];
                foreach($request->settings as $id => $value) {
                    $user_settings[$id] = ['value' => $value];
                }
                $user->settings()->sync($user_settings);
            }

            $msg = 'User was created successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/users')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->user->with('settings')->whereId($id)->first();
        $settings = UserSetting::select('id', 'name', 'key', 'default')->orderBy('key', 'DESC')->get();

        return view('berrier::admin.users.edit')->with(compact('user'))->with(compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);

        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        $request->merge(['last_login' => ($request->last_login) ? $request->last_login : null]);

        if($user->update($request->except('_token'))) {
            if($request->has('settings')) {
                $user_settings = [];
                foreach ($request->settings as $id => $value) {
                    $user_settings[$id] = ['value' => $value];
                }
                $user->settings()->sync($user_settings);
            }

            $msg = 'User was updated successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        return redirect('admin/users')->with('msg', $msg)->with('msg_type', $msg_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);

        if($user->delete()) {
            $msg = 'User deleted successfully';
            $msg_type = 'success';
        }else {
            $msg = 'Something went wrong';
            $msg_type = 'danger';
        }

        if(\Request::ajax()) {
            return response(['msg' => $msg, 'msg_type' => $msg_type]);
        }

        return redirect('admin/users')->with('msg', $msg)->with('msg_type', $msg_type);
    }
}
