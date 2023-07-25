<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\FileUploadController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getAllFileUploadCloud/{option}',[
    FileUploadController::class,
    'getAllFileUpload'
]);

Route::get('/getFileUpload/{option}/{key}',[
    FileUploadController::class,
    'getFileUpload'
]);

Route::post('/fileUploadToCloud/{option}',[
    FileUploadController::class,
    'fileUploadToCloud'
]);

Route::get('/fileDownLoadCloud/{option}/{key}',[
    FileUploadController::class,
    'fileDownLoadCloud'
]);

Route::delete('/fileDeleteCloud/{option}/{key}',[
    FileUploadController::class,
    'fileDeleteCloud'
]);