<?php

namespace Wislem\Berrier\Http\Controllers\Modules\Media;

use App\Events\MediaDeleting;
use Wislem\Berrier\Http\Requests\StoreMediaRequest;
use Wislem\Berrier\Models\Item;
use Wislem\Berrier\Models\Media;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    protected $medium;

    public function __construct(Media $medium)
    {
        $this->medium = $medium;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMediaRequest  $request
     * @return Response
     */
    public function store(StoreMediaRequest $request)
    {
        if($request->ajax()) {
            $response = ['error' => 1, 'path' => ''];

            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $folder = '/public/uploads/' . $request->folder;
                if (!\Storage::exists($folder)) {
                    \Storage::makeDirectory($folder);
                }
                $path = $folder . '/' . date('Y-m-d');
                $hashed = sha1(Str::slug($file->getClientOriginalName() . time())) . '.' . $file->getClientOriginalExtension();

                if (!\Storage::exists($path)) {
                    \Storage::makeDirectory($path);
                }

                if ($file->move(storage_path('app') . $path, $hashed)) {

                    $path = str_replace('/public', '', $path);

                    $medium = $this->medium->create([
                        'path' => $path . '/' . $hashed
                    ]);

                    if($medium) {
                        $response['error'] = 0;
                        $response['path'] = $path.'/'.$hashed;
                        return response($response, 200);
                    }
                    // TODO: ln -s storage/app/public/uploads /path/to/public_html/public
                }
            }
        }

        return response('error', 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $response = ['error' => 0, 'msg' => 'Image deleted successfully', 'msg_type' => 'success'];
        $medium = $this->medium->wherePath($request->path)->first();

        if(!$medium) {
            $response['msg'] = 'Image not found';
            $response['msg_type'] = 'danger';
            $response['error'] = 1;

            return response($response, 400);
        }

        if(!$medium->delete()) {
            $response['msg'] = 'Something went wrong';
            $response['msg_type'] = 'danger';
            $response['error'] = 1;

            return response($response, 400);
        }

        return response($response);
    }
}
