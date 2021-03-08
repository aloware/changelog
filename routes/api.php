<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/{project_uuid}/changelogs', [\App\Http\Controllers\ProjectController::class, 'getChangeLogs'])->name('project-changelogs');

Route::get('/{project_uuid}/published/changelogs', [\App\Http\Controllers\ProjectController::class, 'getPublishedChangelogs'])->name('project-published-changelogs');

Route::get('/company/{company_id}/categories', [\App\Http\Controllers\CategoryController::class, 'getByCompanyId'])->name('company-categories');

Route::get('/project/changelog/image/{filename}', [\App\Http\Controllers\ProjectController::class, 'getImage']);
