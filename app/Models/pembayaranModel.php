<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaranModel extends Model
{
    use HasFactory;
    protected $table='pembayaran';
    protected $primaryKey='id_pembayaran';
    protected $fillable=[
    	'id_petugas','nisn','tgl_bayar','bulan_spp','tahun_spp'
    ];
}
