<?php

namespace App\Http\Controllers;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\ConceptModel;
use App\Models\Product;
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
        $concepts = $request->concept ?? [];
        $ConceptEntity = [];

        foreach ($concepts as $concept) {
            $product = Product::find($concept['product_id']);

            if (!$product) {
                return response()->json(['error' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
            }

            $ConceptEntity[] = new ConceptEntity(
                $concept['quantity'],
                $product->price,
                $product->price * $concept['quantity'], // aquí calculamos el total
                $concept['product_id']
            );
        }
        $saleEntity = new SaleEntity(
            null,
            $email = $request->email ?? null,
            $saleDate = $request->sale_date ?? now(),
            $ConceptEntity
        );

        $sale = SaleModel::create([
            'email' => $saleEntity->email,
            'sale_date' => $saleEntity->sale_date,
            'total' => $saleEntity->total,
        ]);
        $sale->save();

        foreach ($ConceptEntity as $conceptEntity) {
            $concept = ConceptModel::create([
                'quantity' => $conceptEntity->quantity,
                'price' => $conceptEntity->price,
                'product_id' => $conceptEntity->product_id,
                'sale_id' => $sale->id

            ]);
            $concept->save();
        }

        return response()->json($saleEntity, Response::HTTP_CREATED);
    }
}
