<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Siswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id_nisn');
            $table->string('nis',100);
            $table->string('nama',200);
            $table->integer('id_kelas');
            $table->text('alamat');
            $table->string('no_telp',30);
            $table->string('username',100);
            $table->string('password',200);
            /*$table->foreign('id_kelas')->references('id_kelas')->on('kelas');*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
