<?php

namespace App\Http\Controllers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\Services\EncryptorService;
use App\Business\Services\HiService;
use App\Business\Services\ProductService;
use App\Business\Services\SingletonService;
use App\Business\Services\UserService;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected EncryptorService $encryptorService,
        protected UserService $userService,
        protected MessageServiceInterface $hiService,
        protected SingletonService $singletonService,
    ) {}
    
    public function message(MessageServiceInterface $hiService)
    {
        return response()->json($this->hiService->hi());
    }

    public function iva(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Producto No Encontrado: '], Response::HTTP_NOT_FOUND);
        }

        $priceWithIVA = $this->productService->calculatePriceWithTax($product->Price);
        return response()->json([
            'product' => $product->name,
            'price' => $product->Price,
            'priceWithIVA' => $priceWithIVA
        ]);
    }

    public function encrypt($data)
    {
        return response()->json($this->encryptorService->encrypt($data));
    }

    public function decrypt($data)
    {
        return response()->json($this->encryptorService->decrypt($data));
    }

    public function encryptemail(int $id)
    {
        $emailencrypted = $this->userService->encryptEmail($id);
        return response()->json($emailencrypted);
    }

    public function singleton(SingletonService $singletonService2)
    {
        return response()->json($this->singletonService->value." ".$singletonService2->value);
    }

    public function encryptemail2(int $id)
    {
        $userService = app()->make(UserService::class);
        $emailencrypted = $userService->encryptEmail($id);
        return response()->json($emailencrypted);
    }
}
