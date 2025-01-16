<?php

use App\Http\Controllers\API\Avizo\AvizoEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {

   return 'ИВАН ПРИВЕТ';

});


Route::prefix('/avizos')->group(function () {

    Route::prefix('/emails')->group(function () {

        Route::any('/{uuid}/confirm', [AvizoEmailController::class, 'confirm'])->name('avizos.emails.confirm')->whereUuid('uuid');

    });

});

