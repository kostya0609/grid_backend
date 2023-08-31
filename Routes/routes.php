<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Grids\Controllers;

//Route::prefix('api')
//    ->group(function()
//    {
        Route::prefix('grid')
            ->group(function()
            {
                Route::post('/home', Controllers\GridController::class.'@addOrGet');

                Route::prefix('setting')
                    ->group(function()
                    {
                        Route::post('/add', Controllers\GridController::class.'@addSetting');
                        Route::post('/get', Controllers\GridController::class.'@getSetting');
                    });

                Route::prefix('filter')
                    ->group(function()
                    {
                        Route::prefix('preset')
                            ->group(function()
                            {
                                Route::post('/add',     Controllers\FilterPresetController::class.'@add');
                                Route::post('/list',    Controllers\FilterPresetController::class.'@list');
                                Route::post('/edit',    Controllers\FilterPresetController::class.'@edit');
                                Route::post('/delete',  Controllers\FilterPresetController::class.'@delete');

                                Route::prefix('default')
                                    ->group(function()
                                    {
                                        Route::post('/add', Controllers\FilterPresetDefaultController::class.'@add');
                                        Route::post('/get', Controllers\FilterPresetDefaultController::class.'@get');
                                    });
                            });
                    });
            });
    //});
