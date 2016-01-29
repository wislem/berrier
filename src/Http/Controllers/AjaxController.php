<?php
namespace Wislem\Berrier\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{

    public function slugIt(Request $request)
    {
        return Str::slug($request->title);
    }

}