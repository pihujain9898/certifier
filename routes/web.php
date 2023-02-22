<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialLoginController;

Route::get('/', [UserController::class, 'showHomePage']);

Route::get('/error', function () {return view('error');});

Route::get('/login', [UserController::class, 'showLogin']);
Route::post('/login', [UserController::class, 'userLogin']);

Route::get('/login/{provider}', [SocialLoginController::class, 'redirect']);
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'callback']);

Route::get('/signup', [UserController::class, 'showSignup']);
Route::post('/signup', [UserController::class, 'createUser']);

// Put user middleware here
Route::middleware(['middleware' => 'userLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/projects', [CertificateController::class, 'showProjects']);
    Route::post('/project', [CertificateController::class, 'createProject']);

    Route::get('/certificate/{id}', [CertificateController::class, 'uploadCertificate']);
    Route::post('/certificate/{id}', [CertificateController::class, 'storeCertificate']);
    
    Route::get('/template/{id}', [CertificateController::class, 'savedCert']);
    Route::post('/template/{id}', [CertificateController::class, 'setAttributes']);

    Route::get('/upload-data/{id}', [CertificateController::class, 'uploadDataTable']);
    Route::post('/upload-data/{id}', [CertificateController::class, 'storeDataTable']);
    
    Route::get('/show-data/{id}', [CertificateController::class, 'showDataTable']);
    Route::post('/set-data/{id}', [CertificateController::class, 'getDataAttribs']);
    
    Route::get('/mail-certificate/{id}', [MailController::class, 'getMailCred']);
    Route::post('/save-mail/{id}', [MailController::class, 'setMailCred']);
    Route::post('/mail-certificate/{id}', [MailController::class, 'sendMail']);
    
});