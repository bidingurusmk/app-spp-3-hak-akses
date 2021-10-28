<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sppModel;
use Illuminate\Support\Facades\Validator;

class spp extends Controller
{
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'angkatan' => 'required',
            'tahun' => 'required',
            'nominal'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $kelas = sppModel::create([
        	'angkatan'=>$request->get('angkatan'),
        	'tahun'=>$request->get('tahun'),
        	'nominal'=>$request->get('nominal'),
        ]);
        if($kelas){
        	return response()->json(['status'=>true]);
        } else {
        	return response()->json(['status'=>false]);
        }
    }
    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'angkatan' => 'required',
            'tahun' => 'required',
            'nominal'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $kelas = sppModel::where('id_spp',$id)->update([
        	'angkatan'=>$request->get('angkatan'),
        	'tahun'=>$request->get('tahun'),
        	'nominal'=>$request->get('nominal'),
        ]);
        if($kelas){
        	return response()->json(['status'=>true]);
        } else {
        	return response()->json(['status'=>false]);
        }
    }
    public function delete($id)
    {
    	$kelas = sppModel::where('id_spp',$id)->delete();
        if($kelas){
        	return response()->json(['status'=>true]);
        } else {
        	return response()->json(['status'=>false]);
        }
    }
}
