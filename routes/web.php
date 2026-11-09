<?php

use App\Http\Controllers\C_Chart;
use App\Http\Controllers\C_Dosen;
use App\Http\Controllers\C_Home;
use App\Http\Controllers\C_Login;
use App\Http\Controllers\C_Mahasiswa;
use App\Http\Controllers\C_Register;
use App\Http\Controllers\C_User;
use Illuminate\Support\Facades\Route;

Route::get('/', [C_Login::class, 'index'])->name('root');
Route::get('/login', [C_Login::class, 'index'])->name('login');
Route::post('/login', [C_Login::class, 'login'])->name('login.post');
Route::post('/logout', [C_Login::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [C_Register::class, 'index'])->name('register');
Route::post('/register/proses', [C_Register::class, 'register'])->name('register.proses');

Route::middleware('auth')->group(function () {
    Route::get('/home', [C_Home::class, 'index'])->name('home');

    Route::middleware('admin')->group(function () {
        Route::get('/about', [C_Home::class, 'about'])->name('about');
        Route::get('/chart', [C_Chart::class, 'index'])->name('chart');
        Route::get('/invoice', [C_Home::class, 'invoice'])->name('invoice');
    });

    Route::middleware('user')->group(function () {
        Route::get('/user', [C_User::class, 'index'])->name('user');
    });

    Route::middleware('dosen')->group(function () {
        Route::get('/dosen', [C_Dosen::class, 'index'])->name('dosen');
        Route::get('/dosen/print', [C_Dosen::class, 'print'])->name('dosen.print');
        Route::get('/dosen/add', [C_Dosen::class, 'add'])->name('dosen.add');
        Route::post('/dosen/insert', [C_Dosen::class, 'insert'])->name('dosen.insert');
        Route::get('/dosen/detail/{id_dosen}', [C_Dosen::class, 'detail'])->name('dosen.detail');
        Route::get('/dosen/edit/{id_dosen}', [C_Dosen::class, 'edit'])->name('dosen.edit');
        Route::post('/dosen/update/{id_dosen}', [C_Dosen::class, 'update'])->name('dosen.update');
        Route::delete('/dosen/delete/{id_dosen}', [C_Dosen::class, 'delete'])->name('dosen.delete');
    });

    Route::middleware('mahasiswa')->group(function () {
        Route::get('/mahasiswa', [C_Mahasiswa::class, 'index'])->name('mahasiswa');
        Route::get('/mahasiswa/print', [C_Mahasiswa::class, 'print'])->name('mahasiswa.print');
        Route::get('/mahasiswa/add', [C_Mahasiswa::class, 'add'])->name('mahasiswa.add');
        Route::post('/mahasiswa/insert', [C_Mahasiswa::class, 'insert'])->name('mahasiswa.insert');
        Route::get('/mahasiswa/detail/{nim}', [C_Mahasiswa::class, 'detail'])->name('mahasiswa.detail');
        Route::get('/mahasiswa/edit/{nim}', [C_Mahasiswa::class, 'edit'])->name('mahasiswa.edit');
        Route::post('/mahasiswa/update/{nim}', [C_Mahasiswa::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/delete/{nim}', [C_Mahasiswa::class, 'delete'])->name('mahasiswa.delete');
    });
});
