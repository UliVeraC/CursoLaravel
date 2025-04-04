<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\SaleModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function get()
    {
        return response()->json(SaleModel::all(), Response::HTTP_OK);
    }
    public function create(SaleRequest $request)
    {
        return response()->json(null, Response::HTTP_CREATED);
    }
}
