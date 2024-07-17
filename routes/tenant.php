<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
//    Route::get('/', function () {
//        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//    });


    Route::get('/central', function () {
//        $tenant = \App\Models\Tenant::first();

        $user = tenancy()->central(function (){
            $user = \App\Models\User::first();

            return $user;
        });



//        tenancy()->end();
//
//        $user = \App\Models\User::first();
        return $user;

    })->name('user_1');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('tenancy.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::resource('tasks',\App\Http\Controllers\Tenancy\TaskController::class)->except(['show']);

    Route::get('file/{path}',function ($path){
//        return $path;
//        return \Illuminate\Support\Facades\Storage::path($path);
        return response()->file(\Illuminate\Support\Facades\Storage::path($path));
    })->where('path','.*')->name('file');

    require __DIR__.'/auth.php';
});
