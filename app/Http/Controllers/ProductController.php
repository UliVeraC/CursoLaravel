<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product as ModelsProduct;
use Exception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    public function index(Request $request){
        $perPage = $request->query("per_Page",10);
        $page = $request->query("page",0);
        $offset = $page * $perPage;

        $products = ModelsProduct::skip($offset)->take($perPage)->get();

        return response()->json($products);
    }

    public function store(Request $request){
        try{

            $validatedData = $request->validate([
                'name'=> 'required|string|max:255',
                'description' => 'required|string|max:2000',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:category,id'
            ]);
            $product = ModelsProduct::create($validatedData);
            return response()->json($product);
        } catch(ValidationException $e){
            return response()->json(["error" => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(UpdateProductRequest $request, ModelsProduct $product){
        try{

            $validatedData = $request->validated();
            $product->update($validatedData);
            return response()->json(["message"=>"producto actualizaco exitosamente","product" => $product]);
        } catch(Exception $e){
            return response()->json(["error"=>$e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy(ModelsProduct $product){
        $product->delete();

        return response()->json(["message"=>"producto eliminado existosamente"]);
    }
}
