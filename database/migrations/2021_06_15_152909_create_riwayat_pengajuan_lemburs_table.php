<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPengajuanLembursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pengajuan_lemburs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan');
            $table->string('tgl_pengajuan');
            $table->smallInteger('unit_kerja_id');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('pegawai');
            $table->string('jenis_pekerjaan');
            $table->string('status_perubahan');
            $table->string('user_modify');
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
        Schema::dropIfExists('riwayat_pengajuan_lemburs');
    }
}
