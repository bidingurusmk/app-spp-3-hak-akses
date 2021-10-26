<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelasModel extends Model
{
    use HasFactory;
    protected $table='kelas';
    protected $primaryKey='id_kelas';
    protected $fillable=[
    	'nama_kelas','jurusan','angkatan'
    ];
}
