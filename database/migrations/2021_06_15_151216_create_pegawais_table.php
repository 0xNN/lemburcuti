<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nik');
            $table->string('nama_pegawai');
            $table->string('tmp_lahir');
            $table->string('tgl_lahir');
            $table->string('alamat');
            $table->string('no_hp');
            $table->smallInteger('unit_kerja_id');
            $table->smallInteger('pendidikan_id');
            $table->smallInteger('jurusan_id');
            $table->smallInteger('jabatan_id');
            $table->smallInteger('penempatan_id');
            $table->smallInteger('status_pegawai_id');
            $table->smallInteger('user_id');
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
        Schema::dropIfExists('pegawais');
    }
}
