<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AnnulerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',function(){
    return view('login');
})->name('/');

// Home
Route::get('home/page',[App\Http\Controllers\HomeController::class,'index'])->name('home/page');

// route test 
Route::get('form/personal/new',[App\Http\Controllers\TestController::class,'viewTest'])->name('form/personal/new');
Route::post('form/page_test/save',[App\Http\Controllers\TestController::class,'viewTestSave'])->name('form/page_test/save');
Route::post('form/update',[App\Http\Controllers\TestController::class,'update'])->name('form/update');
Route::get('form/delete{id}',[App\Http\Controllers\TestController::class,'delete']);

// report

//Route::get('/date', [ReportController::class,'report'])->name('/date');
//Route::post('form/report',[App\Http\Controllers\ReportController::class,'report'])->name('form/report');

//Route::get('/date', [ReportController::class,'index'])->name('/date');


// getStudentReport

//Route::get('form/student',[App\Http\Controllers\ReportController::class,'fetch_data'])->name('form/student');

Route::get('/daterange', [DateRangeController::class,'index'])->name('/daterange');
Route::post('form/student', [DateRangeController::class,'fetch_data'])->name('form/student');


//ssssssssssssss
//Route::get('users', [ReportController::class, 'report'])->name('users.index');


// form test request
Route::get('form/register',[App\Http\Controllers\LoginController::class,'index'])->name('form/register');
Route::post('form/request/save',[App\Http\Controllers\LoginController::class,'storeRegister'])->name('form/request/save');

// login
Route::get('form/login/view/new',[App\Http\Controllers\LoginController::class,'viewLogin'])->name('form/login/view/new');
Route::post('form/login',[App\Http\Controllers\LoginController::class,'login'])->name('form/login');
Route::get('form/logout',[App\Http\Controllers\LoginController::class,'logout'])->name('form/logout');

//soumision dans obr
Route::post('form/submit-obr',[App\Http\Controllers\RequestController::class,'test'])->name('form/submit-obr');

//Invoice to send to OBR
Route::get('form/users',[App\Http\Controllers\ReportController::class,'index'])->name('form/users');
Route::get('users', [ReportController::class, 'index'])->name('users.index');
Route::get('users/destroy/{id}/', [App\Http\Controllers\ReportController::class, 'destroy']);
Route::get('users/removeall', [App\Http\Controllers\ReportController::class, 'removeall'])->name('users.removeall');
Route::get('/date', [ReportController::class,'index'])->name('/date');

//select by assigeti a la TVA oui ou non

Route::get('/assigeti', [ReportController::class,'indexassigeti'])->name('/assigeti');

// invoice sended to obr
Route::get('form/userse',[App\Http\Controllers\UserController::class,'index'])->name('form/userse');
Route::get('userse', [UserController::class, 'index'])->name('userse.index');
Route::get('users/destroy/{id}/', [App\Http\Controllers\UserController::class, 'destroy']);
Route::get('users/removealle', [App\Http\Controllers\UserController::class, 'removeall'])->name('users.removealle');
Route::get('/datee', [UserController::class,'index'])->name('/datee');


//search NIF
Route::get('/search',[SearchController::class, 'search'])->name('/search');
//Route::post('/find',[SearchController::class, 'find'])->name('web.find');
Route::post('/find',[SearchController::class, 'finder'])->name('web.find');  //vrai


//Annuler une facture
Route::get('/annuler',[AnnulerController::class, 'search'])->name('/annuler');
//Route::post('/find',[SearchController::class, 'find'])->name('web.find');
Route::post('/findere',[AnnulerController::class, 'findere'])->name('web.findere');  //vrai


//nif get test
//Route::post('/find',[SearchController::class, 'findere'])->name('web.find');

//invoice send ( trouver les donnees stocker dans OBR)
Route::get('/invoicesend',[SearchController::class, 'isend'])->name('/invoicesend');
Route::post('/finder',[SearchController::class, 'findere'])->name('web.finder');