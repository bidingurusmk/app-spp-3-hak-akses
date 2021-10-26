<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class petugasModel extends Authenticatable implements JWTSubject
{
	use Notifiable;
    protected $table='petugas';
    protected $primaryKey="id_petugas";
    protected $fillable=[
    	'username','password',	'nama_petugas',	'alamat',	'no_telp','role'
    ];
    public $timestamps=true;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
