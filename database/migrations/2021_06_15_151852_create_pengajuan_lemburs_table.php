<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanLembursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_lemburs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan');
            $table->date('tgl_pengajuan');
            $table->smallInteger('unit_kerja_id');
            $table->boolean('is_finish')->default(0);
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
        Schema::dropIfExists('pengajuan_lemburs');
    }
}
