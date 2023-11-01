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
    Route::get('/delete-level/{id}', [\App\Http\Controllers\SetLevelController::class, 'deleteLevel'])->name("/delete-level/{id}");
    Route::get('/delete-logic/{id}/{key}', [\App\Http\Controllers\SetLevelController::class, 'deleteLogic'])->name("/delete-logic/{id}/{key}");
    Route::get('/set-logic/{id}', [\App\Http\Controllers\SetLevelController::class, 'setLogic'])->name("/set-logic/{id}");
    Route::post('/add-logic', [\App\Http\Controllers\SetLevelController::class, 'addLogic'])->name("/add-logic");

    Route::get('/kuesioner-unverif', [\App\Http\Controllers\KuesionerController::class, 'unVerif'])->name("/kuesioner-unverif");
    Route::get('/kuesioner-all', [\App\Http\Controllers\KuesionerController::class, 'all'])->name("/kuesioner-all");
    Route::get('/kuesioner/{id}', [\App\Http\Controllers\KuesionerController::class, 'getKuesioner'])->name("/kuesioner/{id}");
    Route::get('/kuesioner-verif', [\App\Http\Controllers\KuesionerController::class, 'verif'])->name("/kuesioner-verif");
    
    Route::get('/logout', [\App\Http\Controllers\SuperLoginController::class, 'logout'])->name("logout");
    Route::post('/submit-verif', [\App\Http\Controllers\KuesionerController::class, 'doVerif'])->name("/submit-verif");
    Route::get('/verif-page/{id}/{level}', [\App\Http\Controllers\KuesionerController::class, 'verification'])->name("verif-page/{id}/{level}");
    Route::get('/detail-data/{id}/{level}', [\App\Http\Controllers\KuesionerController::class, 'detailData'])->name("detail-data/{id}/{level}");
    Route::get('/rollback-data/{id}', [\App\Http\Controllers\KuesionerController::class, 'rollback'])->name("rollback-data/{id}");
    Route::get('/import-data', [\App\Http\Controllers\ImportController::class, 'index'])->name("import-data");
    Route::post('/import', [\App\Http\Controllers\ImportController::class, 'importData'])->name("import");

    Route::get('/list-kategori-materi', [\App\Http\Controllers\LmsController::class, 'listKategori'])->name("list-kategori-materi");
    Route::post('/add-kategori', [\App\Http\Controllers\LmsController::class, 'addKategori'])->name("/add-kategori");

    Route::get('/list-materi', [\App\Http\Controllers\LmsController::class, 'listMateri'])->name("list-materi");
    Route::post('/add-materi', [\App\Http\Controllers\LmsController::class, 'addMateri'])->name("add-materi");
    
    Route::get('/sub-materi/{id}/{name}', [\App\Http\Controllers\LmsController::class, 'subMateri'])->name("sub-materi/{id}/{name}");
    Route::post('/add-sub-materi/{id}/{name}', [\App\Http\Controllers\LmsController::class, 'addSubMateri'])->name("add-sub-materi/{id}/{name}");
    Route::get('/approve-materi/{id}/', [\App\Http\Controllers\LmsController::class, 'approve'])->name("approve-materi/{id}");

    Route::get('/list-pengumuman', [\App\Http\Controllers\LmsController::class, 'listPengumuman'])->name("list-pengumuman");
    Route::post('/submit-pengumuman', [\App\Http\Controllers\LmsController::class, 'submitPengumuman'])->name("submit-pengumuman");
    Route::get('/edit-pengumuman/{id}', [\App\Http\Controllers\LmsController::class, 'editPengumuman'])->name("edit-pengumuman/{id}");
    Route::get('/hapus-pengumuman/{id}', [\App\Http\Controllers\LmsController::class, 'deletePengumuman'])->name("hapus-pengumuman/{id}");

    Route::get('/old-portal', [\App\Http\Controllers\OldPortalController::class, 'index'])->name("old-portal");
    Route::get('/user-progres', [\App\Http\Controllers\LmsController::class, 'user_progres'])->name("user-progres");
    Route::get('/user-progres/{id}/materi/{materiid}', [\App\Http\Controllers\LmsController::class, 'detail_user_progres']);

    // Route::get('/export-verif', [\App\Http\Controllers\KuesionerController::class, 'exportKuesionerVerif'])->name("export-verif");
// });
    
Route::get('/export-data-unverif', [\App\Http\Controllers\KuesionerController::class, 'exportKuesionerUnverif'])->name("/export-data-unverif");
Route::get('/export-verif', [\App\Http\Controllers\KuesionerController::class, 'exportKuesionerVerif'])->name("/export-verif");
Route::get('/export-kuesioner/{id}', [\App\Http\Controllers\KuesionerController::class, 'exportKuesioner'])->name("/export-kuesioner/{id}");


Route::post(
    '/vapor/signed-storage-url',
    [\App\Http\Controllers\Content\SignedStorageUrlController::class, 'store']
)->middleware([]);
// Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'getSitemap'])->name('sitemap');
