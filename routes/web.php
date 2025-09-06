<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/', fn() => redirect()->route('orders.create'));

Route::resource('menus', MenuController::class)->except('show');
Route::resource('orders', OrderController::class)->only('index','create','store','show','destroy');
Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');


