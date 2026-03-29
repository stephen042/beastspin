<?php

use Illuminate\Support\Facades\Route;

Route::view('/spin', 'users.spin')->name('spin');
Route::view('/withdraw', 'users.withdraw')->name('withdraw');