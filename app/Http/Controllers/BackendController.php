<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function get(){
        return response()->json([
            'success' => true,
            'message' => 'Hola',
        ]);
    }
}
