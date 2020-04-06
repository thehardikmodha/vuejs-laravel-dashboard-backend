<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('welcome');
    return view('vue');

//    \Spatie\Permission\Models\Role::create([
//       'name' => 'admin',
//    ]);

//    \Spatie\Permission\Models\Permission::create([
//        'name' => 'users.create'
//    ]);
//
//    \Spatie\Permission\Models\Permission::create([
//        'name' => 'users.read'
//    ]);
//
//    \Spatie\Permission\Models\Permission::create([
//        'name' => 'users.update'
//    ]);
//
//    \Spatie\Permission\Models\Permission::create([
//        'name' => 'users.delete'
//    ]);
//
//    \Spatie\Permission\Models\Role::findByName('super-admin')->syncPermissions(\Spatie\Permission\Models\Permission::all());

//    \App\User::query()->find(2)->syncRoles(['admin']);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
