<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SaleModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function get()
    {
        return response()->json(SaleModel::all(), Response::HTTP_OK);
    }
    public function create() {}
}
