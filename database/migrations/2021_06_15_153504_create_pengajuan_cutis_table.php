<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanCutisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_cutis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan');
            $table->smallInteger('pegawai_id');
            $table->smallInteger('unit_kerja_id');
            $table->date('tgl_mulai_dinas');
            $table->smallInteger('bank_legacy_id');
            $table->smallInteger('jenis_cuti_id');
            $table->smallInteger('rencana_cuti_id');
            $table->date('tgl_mulai_cuti');
            $table->date('tgl_selesai_cuti');
            $table->text('alamat_lengkap_selama_cuti');
            $table->string('no_hp_selama_cuti');
            $table->text('keterangan');
            $table->smallInteger('jenis_cuti_extra_id');
            $table->date('tgl_mulai_extra_cuti');
            $table->text('alamat_lengkap_extra_selama_cuti');
            $table->string('no_hp_extra_selama_cuti');
            $table->text('keterangan_extra');
            $table->date('tgl_pengajuan');
            $table->integer('total_hari');
            $table->integer('maksimum_cuti_id');
            $table->integer('sisa_cuti');
            $table->smallInteger('status_pengajuan')->default(0);
            $table->string('alasan_tolak')->nullable();
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
        Schema::dropIfExists('pengajuan_cutis');
    }
}
