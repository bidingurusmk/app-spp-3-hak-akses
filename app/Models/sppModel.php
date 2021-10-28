<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sppModel extends Model
{
    use HasFactory;
    protected $table='spp';
    protected $primaryKey='id_spp';
    protected $fillable=[
    	'angkatan','tahun','nominal'
    ];
}
