<?php

namespace App\Http\Controllers;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;
use Auth;
use App\Models\tunggakanModel;

class siswaController extends Controller
{

	function __construct()
		{
		    Config::set('jwt.user', \App\Models\Siswa::class);
		    Config::set('auth.providers', ['users' => [
		            'driver' => 'eloquent',
		            'model' => \App\Models\Siswa::class,
		        ]]);
		}
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $datauser=JWTAuth::user();
        return response()->json(compact('token','datauser'));
    }

   
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'nisn'=>'required|string|max:255|unique:siswa',
        	'nis'=>'required|string|max:255',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:siswa',
            'alamat'=>'required|string',
            'no_telp'=>'required|string|max:255',
            'id_kelas'=>'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $siswa = Siswa::create([
        	'nisn'=>$request->get('nisn'),
        	'nis'=>$request->get('nis'),
        	'nama'=>$request->get('nama'),
        	'alamat'=>$request->get('alamat'),
        	'no_telp'=>$request->get('no_telp'),
        	'username'=>$request->get('username'),
        	'password'=>Hash::make($request->get('password')),
        	'id_kelas'=>$request->get('id_kelas'),
        ]);
        $token = JWTAuth::fromUser($siswa);
        return response()->json(compact('siswa','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
    public function getprofile()
    {
    	return response()->json(['data'=>JWTAuth::user()]);
    }
    public function gethistori()
    {
        $histori=tunggakanModel::join('siswa','siswa.nisn','tunggakan.nisn')->where('tunggakan.nisn',JWTAuth::user()->nisn)->where('status_lunas','Lunas')->get();
        return response()->json($histori);
    }
    public function getkurangbayar()
    {
        $daftarbelumbayar=tunggakanModel::join('siswa','siswa.nisn','tunggakan.nisn')->join('kelas','kelas.id_kelas','siswa.id_kelas')->join('spp','spp.angkatan','kelas.angkatan')->where('tunggakan.nisn',JWTAuth::user()->nisn)->where('status_lunas','Belum Lunas')->get();

        $kurangbayar=tunggakanModel::join('siswa','siswa.nisn','tunggakan.nisn')->join('kelas','kelas.id_kelas','siswa.id_kelas')->join('spp','spp.angkatan','kelas.angkatan')->where('tunggakan.nisn',JWTAuth::user()->nisn)->where('status_lunas','Belum Lunas')->sum('spp.nominal');
        return response()->json(compact('daftarbelumbayar','kurangbayar'));
    }
}

