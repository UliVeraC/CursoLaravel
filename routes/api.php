<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuerysController;
use App\Http\Middleware\UppercaseName;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\LogRequests;

Route::get('/test', function () {
    return 'El backend funciona';
});

Route::get('/backend', [BackendController::class, "get"])
    /*->middleware("checkvalue: 4545,pato")*/;

Route::get('/query', [QuerysController::class, 'get']);
Route::get('/query/{id}', [QuerysController::class, 'getByID']);

Route::get('/query/method/names', [QuerysController::class, 'getNames']);
Route::get('/query/method/search/{name}/{price}', [QuerysController::class, 'searchName']);
Route::get('/query/method/searchstring/{value}', [QuerysController::class, 'searchString']);
Route::post('/query/method/advancedSearch', [QuerysController::class, 'advancedSearch']);
Route::get('/query/method/join', [QuerysController::class, 'join']);
Route::get('/query/method/group', [QuerysController::class, 'groupBy']);

Route::apiResource("/product", ProductController::class)
    ->middleware([/*"checkvalue","owo"*/'jwt.auth',LogRequests::class]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware("jwt.auth")->group(function (){
    Route::get('who',[AuthController::class, 'who']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::post('refresh',[AuthController::class, 'refresh']);
});

Route::get('/info/message', [InfoController::class , 'message']);
Route::get('/info/tax/{id}', [InfoController::class , 'iva']);
Route::get('/info/encrypt/{data}', [InfoController::class , 'encrypt']);
Route::get('/info/decrypt/{data}', [InfoController::class , 'decrypt']);
Route::get('/info/encryptemail/{id}', [InfoController::class , 'encryptemail']);
Route::get('/info/singleton', [InfoController::class , 'singleton']);

Route::get('/info/encryptemail2/{id}', [InfoController::class , 'encryptemail2']);
Route::get('/api', [ApiController::class , 'get']);