<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RequestController;



use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\getInvoiceController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\Users;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// login


route::get('all-post', [RequestController::class, 'getAllPost']); 
route::get('single-post/{id}', [RequestController::class, 'singlePost']); 
route::post('addpost', [RequestController::class, 'addPost']); 
route::get('post/edit/{id}', [RequestController::class, 'edit'])->name('post.edit');



route::post('addadd', [RequestController::class, 'postGuzzleRequest']); 
route::post('logine', [RequestController::class, 'login']); 


Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);

Route::post('/data', [getInvoiceController::class, 'show']);


//nif
route::post('nif', [SearchController::class, 'finder']); 