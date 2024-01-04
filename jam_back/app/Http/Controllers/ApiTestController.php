<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status' => "OK"
        ]);
    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
}
