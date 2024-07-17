<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//    foreach (config('tenancy.central_domains') as $domain) {
//        Route::domain($domain)->group(function () {
//
//        });
//    }


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/user_1', function () {
        $tenant = \App\Models\Tenant::first();

        tenancy()->initialize($tenant);

        $user = \App\Models\User::first();

        tenancy()->end();

        $user = \App\Models\User::first();
        return $user;

    })->name('user_1');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tenants',\App\Http\Controllers\TenantController::class)->except(['show']);
});



require __DIR__.'/auth.php';


