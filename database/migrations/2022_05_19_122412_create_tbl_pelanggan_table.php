<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pelanggan', function (Blueprint $table) {
            $table->string('kode_pelanggan');
            $table->string('nik');
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_telpn');
            $table->string('email');
            $table->string('catatan');
            $table->string('file');
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
        Schema::dropIfExists('tbl_pelanggan');
    }
}
