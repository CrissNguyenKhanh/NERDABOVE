<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\GenerateController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Ajax\MenuController as AjaxMenuController;
use App\Http\Controllers\Backend\ProductCatalogueController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\AttributeCatalogueController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Backend\MenuController;


//@@useController@@

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

Route::get('/', function () {
    return view('welcome');
});

/* BACKEND ROUTES */


Route::group(['middleware' => ['admin','locale','backend_default_locale']], function () {  
   Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

   /* USER */
   Route::group(['prefix' => 'user'], function () {
      Route::get('index', [UserController::class, 'index'])->name('user.index');
      Route::get('create', [UserController::class, 'create'])->name('user.create');
      Route::post('store', [UserController::class, 'store'])->name('user.store');
      Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
      Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
      Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
      Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
   });


   Route::group(['prefix' => 'user/catalogue'], function () {
      Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
      Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
      Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
      Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
      Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
      Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
      Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
      Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
      Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.updatePermission');
   });

   Route::group(['prefix' => 'language'], function () {
      Route::get('index', [LanguageController::class, 'index'])->name('language.index')->middleware(['admin','locale']);
      Route::get('create', [LanguageController::class, 'create'])->name('language.create');
      Route::post('store', [LanguageController::class, 'store'])->name('language.store');
      Route::get('{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit');
      Route::post('{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update');
      Route::get('{id}/delete', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete');
      Route::delete('{id}/destroy', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy');
      Route::get('{id}/switch', [LanguageController::class, 'swicthBackendLanguage'])->where(['id' => '[0-9]+'])->name('language.switch');
      Route::get('{id}/{languageId}/{model}/translate', [LanguageController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('language.translate');
      Route::post('storeTranslate', [LanguageController::class, 'storeTranslate'])->name('language.storeTranslate');
   });

   Route::group(['prefix' => 'generate'], function () {
      Route::get('index', [GenerateController::class, 'index'])->name('generate.index')->middleware(['admin','locale']);
      Route::get('create', [GenerateController::class, 'create'])->name('generate.create');
      Route::post('store', [GenerateController::class, 'store'])->name('generate.store');
      Route::get('{id}/edit', [GenerateController::class, 'edit'])->where(['id' => '[0-9]+'])->name('generate.edit');
      Route::post('{id}/update', [GenerateController::class, 'update'])->where(['id' => '[0-9]+'])->name('generate.update');
      Route::get('{id}/delete', [GenerateController::class, 'delete'])->where(['id' => '[0-9]+'])->name('generate.delete');
      Route::delete('{id}/destroy', [GenerateController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('generate.destroy');
   });

   Route::group(['prefix' => 'system'], function () {
      Route::get('index', [SystemController::class, 'index'])->name('system.index');
      Route::post('store', [SystemController::class, 'store'])->name('system.store');
      Route::get('{languageId}/translate', [SystemController::class, 'translate'])->where(['languageId'=>'[0-9]+'])->name('system.translate');
      Route::post('{languageId}/saveTranslate', [SystemController::class, 'saveTranslate'])->where(['languageId'=>'[0-9]+'])->name('system.save.translate');


   });


   Route::group(['prefix' => 'post/catalogue'], function () {
      Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
      Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
      Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
      Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
      Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
      Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
      Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
   });

   
   Route::group(['prefix' => 'menu'], function () {
      Route::get('index', [MenuController::class, 'index'])->name('menu.index');
      Route::get('create', [MenuController::class, 'create'])->name('menu.create');
      Route::post('store', [MenuController::class, 'store'])->name('menu.store');
      Route::get('{id}/edit', [MenuController::class, 'edit'])->where(['id' => '[0-9]+'])->name('menu.edit');
      Route::post('{id}/update', [MenuController::class, 'update'])->where(['id' => '[0-9]+'])->name('menu.update');
      Route::get('{id}/delete', [MenuController::class, 'delete'])->where(['id' => '[0-9]+'])->name('menu.delete');
      Route::delete('{id}/destroy', [MenuController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('menu.destroy');
   });
   Route::group(['prefix' => 'post'], function () {
      Route::get('index', [PostController::class, 'index'])->name('post.index');
      Route::get('create', [PostController::class, 'create'])->name('post.create');
      Route::post('store', [PostController::class, 'store'])->name('post.store');
      Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
      Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
      Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
      Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
   });

   Route::group(['prefix' => 'permission'], function () {
      Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
      Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
      Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
      Route::get('{id}/edit', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('permission.edit');
      Route::post('{id}/update', [PermissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('permission.update');
      Route::get('{id}/delete', [PermissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('permission.delete');
      Route::delete('{id}/destroy', [PermissionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('permission.destroy');
   });

Route::group(['prefix' => 'product/catalogue'], function () {
    Route::get('index', [ProductCatalogueController::class, 'index'])->name('product.catalogue.index');
    Route::get('create', [ProductCatalogueController::class, 'create'])->name('product.catalogue.create');
    Route::post('store', [ProductCatalogueController::class, 'store'])->name('product.catalogue.store');
    Route::get('{id}/edit', [ProductCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('product.catalogue.edit');
    Route::post('{id}/update', [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('product.catalogue.update');
    Route::get('{id}/delete', [ProductCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.catalogue.delete');
    Route::delete('{id}/destroy', [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.catalogue.destroy');
});
Route::group(['prefix' => 'product'], function () {
    Route::get('index', [ProductController::class, 'index'])->name('product.index');
    Route::get('create', [ProductController::class, 'create'])->name('product.create');
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('product.edit');
    Route::post('{id}/update', [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('product.update');
    Route::get('{id}/delete', [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('product.delete');
    Route::delete('{id}/destroy', [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('product.destroy');
});
Route::group(['prefix' => 'attribute/catalogue'], function () {
    Route::get('index', [AttributeCatalogueController::class, 'index'])->name('attribute.catalogue.index');
    Route::get('create', [AttributeCatalogueController::class, 'create'])->name('attribute.catalogue.create');
    Route::post('store', [AttributeCatalogueController::class, 'store'])->name('attribute.catalogue.store');
    Route::get('{id}/edit', [AttributeCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.edit');
    Route::post('{id}/update', [AttributeCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.update');
    Route::get('{id}/delete', [AttributeCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.delete');
    Route::delete('{id}/destroy', [AttributeCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.catalogue.destroy');
});
Route::group(['prefix' => 'attribute'], function () {
    Route::get('index', [AttributeController::class, 'index'])->name('attribute.index');
    Route::get('create', [AttributeController::class, 'create'])->name('attribute.create');
    Route::post('store', [AttributeController::class, 'store'])->name('attribute.store');
    Route::get('{id}/edit', [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('attribute.edit');
    Route::post('{id}/update', [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('attribute.update');
    Route::get('{id}/delete', [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('attribute.delete');
    Route::delete('{id}/destroy', [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('attribute.destroy');
});
//@@new-module@@





   /* AJAX */
   Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');
   Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
   Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
   Route::get('ajax/dashboard/getMenu', [AjaxDashboardController::class, 'getMenu'])->name('ajax.dashboard.getMenu');
   Route::get('ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
   Route::get('ajax/attribute/LoadAttribute', [AjaxAttributeController::class, 'LoadAttribute'])->name('ajax.attribute.LoadAttribute');
   Route::post('ajax/menu/createCatalogue', [AjaxMenuController::class, 'createCatalogue'])->name('ajax.menu.createCatalogue');


});


Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
