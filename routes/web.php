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
    return view('welcome');
});

Route::get('/sample', function () {
    return view('layouts.sample');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('projects/{app_name}/changelogs', [\App\Http\Controllers\ChangelogController::class, 'index'])->name('project-changelogs-view');

    Route::post('project/{project_uuid}/changelogs', [\App\Http\Controllers\ChangelogController::class, 'store'])->name('store-changelogs');

    Route::put('project/changelogs/{id}', [\App\Http\Controllers\ChangelogController::class, 'update'])->name('store-changelogs');

    Route::delete('project/changelogs/{id}', [\App\Http\Controllers\ChangelogController::class, 'destroy'])->name('delete-changelogs');

    Route::post('project/{project_uuid}/changelogs/upload/image', [\App\Http\Controllers\ProjectController::class, 'uploadImage'])->name('changelogs-image-upload');

    Route::get('project/{project_uuid}/settings', [\App\Http\Controllers\ProjectController::class, 'settings'])->name('project-settings');

});


Route::get('{app_name}/changelogs', [\App\Http\Controllers\ProjectController::class, 'getPageView'])->name('page-changelogs-view');

Route::get('{projectUuid}/widgets', [\App\Http\Controllers\ProjectController::class, 'getWidgetView'])->name('widget-changelogs-view');
