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
                $path = '/public/uploads/' . $request->folder . '/' . date('Y-m-d');
                $destination = storage_path('app' . $path);
                $hashed = sha1(Str::slug($file->getClientOriginalName() . time())) . '.' . $file->getClientOriginalExtension();

                if (!\File::exists($destination)) {
                    \File::makeDirectory($destination);
                }

                $path = str_replace('/public', '', $path);

                if ($file->move($destination, $hashed)) {
                    $medium = $this->medium->create([
                        'path' => $path . '/' . $hashed
                    ]);

                    if($medium) {
                        $response['error'] = 0;
                        $response['path'] = $path.'/'.$hashed;
                        return response($response, 200);
                    }
                    // TODO: ln -s /path/to/public_html/storage/app/public/uploads /path/to/public_html/public/uploads
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
