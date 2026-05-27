<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',                        [OrderController::class, 'index'])->name('home');
Route::get('/order/{type}',            [OrderController::class, 'order'])->name('order')
     ->where('type', 'robot|menu');
Route::post('/checkout',               [OrderController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{order_number}',   [OrderController::class, 'ticket'])->name('ticket');


Route::get('/scanner',              [OrderController::class, 'scanner'])->name('scanner');
Route::post('/api/scan-order',      [OrderController::class, 'scan']);
