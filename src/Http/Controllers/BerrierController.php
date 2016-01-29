<?php

namespace Wislem\Berrier\Http\Controllers;

use Illuminate\Routing\Controller;


class BerrierController extends Controller
{

    public function dashboard()
    {
        return view('berrier::admin.dashboard');
    }

}