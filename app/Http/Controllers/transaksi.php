<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembayaranModel;
use JWTAuth;
use Validator;
use App\Models\tunggakanModel;

class transaksi extends Controller
{
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'nisn' => 'required',
            'bulan_spp'=>'required',
            'tahun_spp'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $ceklunas=tunggakanModel::where('nisn',$request->get('nisn'))
        	->where('bulan_spp',$request->get('bulan_spp'))
        	->where('tahun_spp',$request->get('tahun_spp'));
        if($ceklunas->count()>0){
        	$dt_status=$ceklunas->first();
        	if($dt_status->status_lunas=="Belum Lunas"){
	        	$pembayaran = pembayaranModel::create([
		        	'id_petugas'=>JWTAuth::user()->id_petugas,
		        	'nisn'=>$request->get('nisn'),
		        	'tgl_bayar'=>date('Y-m-d'),
		        	'bulan_spp'=>$request->get('bulan_spp'),
		        	'tahun_spp'=>$request->get('tahun_spp'),
		        ]);
		        if($pembayaran){
		        	$updat_tunggakan=tunggakanModel::where('nisn',$request->get('nisn'))
		        	->where('bulan_spp',$request->get('bulan_spp'))
		        	->where('tahun_spp',$request->get('tahun_spp'))
		        	->update([
		        		'status_lunas'=>'Lunas'
		        	]);
		        	return response()->json(['message'=>'sukses pembayaran','status'=>true]);
		        } else {
		        	return response()->json(['message'=>'Gagal pembayaran','status'=>false]);
		        }
	        } elseif($dt_status->status_lunas=="Lunas"){
	        	return response()->json(['message'=>'Bulan ini sudah lunas, tidak perlu membayar','status'=>false]);
	        } 
        } else {
	        	return response()->json(['message'=>'Tidak ada tunggakan','status'=>false]);
	        }
        
        
    }
    public function kurang_bayar($id)
    {
    	$gethistori=tunggakanModel::select('siswa.nisn','siswa.nama','kelas.nama_kelas','kelas.jurusan','nominal')->join('siswa','siswa.nisn','=','tunggakan.nisn')
    	->join('kelas','kelas.id_kelas','=','siswa.id_kelas')
    	->join('spp','spp.angkatan','=','kelas.angkatan')
    	->where('tunggakan.nisn',$id)
    	->where('status_lunas','Belum Lunas')
    	->get();
    	return response()->json($gethistori);
    }
}
