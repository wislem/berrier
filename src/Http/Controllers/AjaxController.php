<?php
namespace Wislem\Berrier\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Wislem\Berrier\Http\Requests\StoreMediaRequest;

class AjaxController extends Controller
{

    public function slugIt(Request $request)
    {
        return Str::slug($request->title);
    }

    public function upload(StoreMediaRequest $request)
    {
        if($request->ajax()) {
            $response = ['filelink' => ''];

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
                    $response['filelink'] = config('app.url') . str_replace('/public', '', $path) . '/' . $hashed;
                    return response($response, 200);
                    // TODO: ln -s storage/app/public/uploads /path/to/public_html/public
                }
            }
        }

        return response('error', 400);
    }
}