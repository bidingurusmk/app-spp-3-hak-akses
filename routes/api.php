<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\siswaController;
use App\Http\Controllers\kelolaKelas;
use App\Http\Controllers\kelolaSiswa;
use App\Http\Controllers\spp;
use App\Http\Controllers\transaksi;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'login']);
Route::post('register_siswa', [siswaController::class,'register']);
Route::post('login_siswa', [siswaController::class,'login']);

Route::group(['middleware'=>['jwt.verify:petugas']],function(){
	Route::get('/get_profile',[UserController::class,'getprofile']);
	Route::post('/pembayaran',[transaksi::class,'store']);
	Route::get('/kurang_bayar/{id}',[transaksi::class,'kurang_bayar']);
	Route::get('/getsiswabynisn/{id}',[transaksi::class,'getSiswaByNisn']);
});

Route::group(['middleware'=>['jwt.verify:admin']],function(){
	Route::get('/get_profile_admin',[UserController::class,'getprofileadmin']);
	Route::post('/insertkelas',[kelolaKelas::class,'store']);
	Route::put('/updatekelas/{id}',[kelolaKelas::class,'update']);
	Route::delete('/deletekelas/{id}',[kelolaKelas::class,'delete']);

	Route::post('/insertsiswa',[kelolaSiswa::class,'store']);
	Route::put('/updatesiswa/{id}',[kelolaSiswa::class,'update']);
	Route::delete('/deletesiswa/{id}',[kelolaSiswa::class,'delete']);

	Route::post('/insertspp',[spp::class,'store']);
	Route::put('/updatespp/{id}',[spp::class,'update']);
	Route::delete('/deletespp/{id}',[spp::class,'delete']);
});

Route::group(['middleware'=>['jwt.verifysiswa']],function(){
	Route::get('/get_profile_siswa',[siswaController::class,'getprofile']);
});



