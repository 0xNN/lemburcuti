<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanLemburDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_lembur_details', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('pengajuan_lembur_id');
            $table->smallInteger('pegawai_id');
            $table->string('jenis_pekerjaan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
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
        Schema::dropIfExists('pengajuan_lembur_details');
    }
}
