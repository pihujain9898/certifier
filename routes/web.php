<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;

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

Route::get('/', [UserController::class, 'showHomePage']);

Route::get('/error', function () {return view('error');});

Route::get('/login', [UserController::class, 'showLogin']);
Route::post('/login', [UserController::class, 'userLogin']);

Route::get('/signup', [UserController::class, 'showSignup']);
Route::post('/signup', [UserController::class, 'createUser']);

// Route::get('/home', [UserController::class, 'showDashboard']);

// Put user middleware here
Route::middleware(['middleware' => 'userLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/projects', [CertificateController::class, 'showProjects']);
    Route::post('/create-project', [CertificateController::class, 'createProject']);

    Route::get('/upload-certificate/{id}', [CertificateController::class, 'uploadCertificate']);
    Route::post('/upload-certificate/{id}', [CertificateController::class, 'storeCertificate']);
    
    Route::get('/savedCertificate/{id}', [CertificateController::class, 'savedCert']);
    Route::post('/set-attributes/{id}', [CertificateController::class, 'setAttributes']);

    Route::get('/upload-data-table/{id}', [CertificateController::class, 'uploadDataTable']);
    Route::post('/upload-data-table/{id}', [CertificateController::class, 'storeDataTable']);
    
    Route::get('/show-data-table/{id}', [CertificateController::class, 'showDataTable']);
    Route::post('/get-data-attribs/{id}', [CertificateController::class, 'getDataAttribs']);
    
    Route::get('/mail-certificate/{id}', [MailController::class, 'getMailCred']);
    Route::post('/save-mail/{id}', [MailController::class, 'setMailCred']);
    Route::post('/mail-certificate/{id}', [MailController::class, 'sendMail']);
    
});