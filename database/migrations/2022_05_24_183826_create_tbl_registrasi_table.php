<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRegistrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_registrasi', function (Blueprint $table) {
            $table->increments('kode_reg');
            $table->string('kode_paket');
            $table->string('kode_pelanggan');
            $table->string('pajak');
            $table->string('note');
            $table->string('file');
            $table->string('status');
            $table->string('start_reg');
            $table->string('end_reg');
            $table->string('bulan');
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
        Schema::dropIfExists('tbl_registrasi');
    }
}
