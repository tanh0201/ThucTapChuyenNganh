<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;



Route::get('/', function () {
    return view('layout/home');
});

;Route::get('/admin', function () {
    return view('admin/admin');
});

