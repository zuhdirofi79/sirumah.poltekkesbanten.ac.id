<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SirumahController as C;
Route::get('/',[C::class,'home'])->name('home');
Route::get('/login',[C::class,'loginForm'])->name('login');
Route::post('/login',[C::class,'login'])->middleware('throttle:6,1');
Route::get('/register',[C::class,'registerForm'])->name('register');
Route::post('/register',[C::class,'register'])->middleware('throttle:5,1');
Route::post('/logout',[C::class,'logout'])->name('logout');
Route::get('/locations/{location}/buildings',[C::class,'buildings'])->whereNumber('location');
Route::get('/buildings/{building}/floors',[C::class,'floors'])->whereNumber('building');
Route::get('/floors/{floor}/rooms',[C::class,'rooms'])->whereNumber('floor');
Route::middleware('auth')->group(function () {
 Route::get('/dashboard',[C::class,'dashboard'])->name('dashboard');
 Route::get('/reports/create',[C::class,'create'])->name('reports.create');
 Route::post('/reports',[C::class,'store'])->name('reports.store')->middleware('throttle:12,1');
 Route::get('/reports',[C::class,'index'])->name('reports.index');
 Route::get('/reports/{report}',[C::class,'show'])->name('reports.show');
 Route::get('/reports/{report}/media/{media}',[C::class,'media'])->name('reports.media');
 Route::get('/notifications',[C::class,'notifications'])->name('notifications');
 Route::post('/reports/{report}/updates',[C::class,'updateStatus'])->name('reports.updates');
 Route::get('/admin/settings',[C::class,'settings'])->name('settings');
 Route::post('/admin/master',[C::class,'saveMaster'])->name('master.save');
 Route::post('/admin/users',[C::class,'saveUser'])->name('users.save');
 Route::post('/admin/users/{user}/toggle',[C::class,'toggleUser'])->name('users.toggle');
});
