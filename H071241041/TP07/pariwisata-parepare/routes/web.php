<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/destinasi', function () {
    return view('destinasi');
});

Route::get('/kuliner', function () {
    return view('kuliner');
});

Route::get('/galeri', function () {
    return view('galeri');
});

Route::get('/kontak', function () {
    return view('kontak');
});
