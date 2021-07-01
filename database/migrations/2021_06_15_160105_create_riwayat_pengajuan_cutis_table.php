<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPengajuanCutisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pengajuan_cutis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan');
            $table->smallInteger('pegawai_id');
            $table->smallInteger('unit_kerja_id');
            $table->smallInteger('bank_legacy_id');
            $table->smallInteger('jenis_cuti_id');
            $table->date('tgl_mulai_cuti');
            $table->date('tgl_selesai_cuti');
            $table->smallInteger('jenis_cuti_extra_id');
            $table->date('tgl_pengajuan');
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
        Schema::dropIfExists('riwayat_pengajuan_cutis');
    }
}
