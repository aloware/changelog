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

    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('home');
    }

    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('projects/{uuid}/changelogs', [\App\Http\Controllers\ChangelogController::class, 'index'])->name('project-changelogs-view');

    Route::post('project/{project_uuid}/changelogs', [\App\Http\Controllers\ChangelogController::class, 'store'])->name('store-changelogs');

    Route::put('project/changelogs/{id}', [\App\Http\Controllers\ChangelogController::class, 'update'])->name('store-changelogs');

    Route::delete('project/changelogs/{id}', [\App\Http\Controllers\ChangelogController::class, 'destroy'])->name('delete-changelogs');

    Route::post('project/{project_uuid}/changelogs/upload/image', [\App\Http\Controllers\ProjectController::class, 'uploadImage'])->name('changelogs-image-upload');

    Route::get('project/{uuid}/settings', [\App\Http\Controllers\ProjectController::class, 'settings'])->name('project-settings');

    Route::post('company/{companyId}/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('store-category');

    Route::put('company/category/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('update-category');

    Route::delete('company/category/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('delete-category');

    Route::get('company/{companyId}/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');

    Route::get('company/{id}/project/add', [\App\Http\Controllers\ProjectController::class, 'create'])->name('create-project');

    Route::post('company/{id}/project', [\App\Http\Controllers\ProjectController::class, 'store'])->name('store-project');

    Route::put('project/{uuid}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('update-project');

    Route::delete('project/{uuid}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('delete-project');

    Route::post('project/{uuid}/logo', [\App\Http\Controllers\ProjectController::class, 'uploadLogo'])->name('upload-project-logo');

    Route::get('company/{companyId}/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');

    Route::post('/user', [\App\Http\Controllers\UserController::class, 'store'])->name('store-user');

    Route::delete('/user/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('delete-user');

    Route::get('/test', function (){
        return view('welcome');
    })->name('widget-test');

});


Route::get('{projectUuid}/changelogs', [\App\Http\Controllers\ProjectController::class, 'getPageView'])->name('page-changelogs-view');

Route::get('{projectUuid}/widgets', [\App\Http\Controllers\ProjectController::class, 'getWidgetView'])->name('widget-changelogs-view');

Route::get('/widget', [\App\Http\Controllers\ProjectController::class, 'widget'])->name('widget-config-view');

Route::get('/user/{id}/set-password', [\App\Http\Controllers\UserController::class, 'setPassword'])->name('set-user-password-view');

Route::post('/user/{id}/set-password', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('set-user-password');
