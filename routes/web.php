<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

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
    return view('users.home');
});

Route::get('/upload-data-table', [CertificateController::class, 'uploadDataTable']);
Route::post('/upload-data-table', [CertificateController::class, 'storeDataTable']);

Route::get('/upload-certificate', [CertificateController::class, 'uploadCertificate']);
Route::post('/upload-certificate', [CertificateController::class, 'storeCertificate']);

Route::get('/set-texts', [CertificateController::class, 'showCertificate']);
Route::post('/set-attributes', [CertificateController::class, 'setAttributes']);
