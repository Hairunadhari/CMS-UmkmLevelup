<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SuperLoginController;
// use App\Http\Controllers\LogoutController;
// use App\Http\Controllers\SetLevelController;

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

Route::post(
    '/stripe/webhook',
    [\App\Http\Controllers\Webhook\StripeController::class, 'handleWebhook']
)->name('cashier.webhook');
  
    
Route::group(['middleware' => ['guest']], function() {  
    Route::get('/login', [\App\Http\Controllers\SuperLoginController::class, 'index'])->name("login");
    Route::post('/process-login', [\App\Http\Controllers\SuperLoginController::class, 'submitLogin'])->name('process-login');
});

Route::redirect('/', '/login');

// Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name("/dashboard");
    Route::get('/set-level', [\App\Http\Controllers\SetLevelController::class, 'index'])->name("/set-level");
    Route::post('/add-level', [\App\Http\Controllers\SetLevelController::class, 'addLevel'])->name("/add-level");
    Route::get('/set-logic/{id}', [\App\Http\Controllers\SetLevelController::class, 'setLogic'])->name("/set-logic/{id}");
    Route::post('/add-logic', [\App\Http\Controllers\SetLevelController::class, 'addLogic'])->name("/add-logic");
    Route::get('/kuesioner-unverif', [\App\Http\Controllers\KuesionerController::class, 'unVerif'])->name("/kuesioner-unverif");
    Route::get('/kuesioner-verif', [\App\Http\Controllers\KuesionerController::class, 'verif'])->name("/kuesioner-verif");
    Route::get('/logout', [\App\Http\Controllers\SuperLoginController::class, 'logout'])->name("logout");
    Route::post('/submit-verif', [\App\Http\Controllers\KuesionerController::class, 'doVerif'])->name("/submit-verif");
    Route::get('/verif-page/{id}/{level}', [\App\Http\Controllers\KuesionerController::class, 'verification'])->name("verif-page/{id}/{level}");
    Route::get('/detail-data/{id}/{level}', [\App\Http\Controllers\KuesionerController::class, 'detailData'])->name("detail-data/{id}/{level}");
    Route::get('/import-data', [\App\Http\Controllers\ImportController::class, 'index'])->name("import-data");
    Route::post('/import', [\App\Http\Controllers\ImportController::class, 'detailData'])->name("import");
// });



Route::post(
    '/vapor/signed-storage-url',
    [\App\Http\Controllers\Content\SignedStorageUrlController::class, 'store']
)->middleware([]);
// Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'getSitemap'])->name('sitemap');
