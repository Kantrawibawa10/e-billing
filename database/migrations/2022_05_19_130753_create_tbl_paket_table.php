<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_paket', function (Blueprint $table) {
            $table->string('kode');
            $table->string('nama_paket');
            $table->string('kategori');
            $table->string('lama_paket');
            $table->string('harga_paket');
            $table->string('nilai_pajak');
            $table->string('subtotal');
            $table->string('deskripsi');
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
        Schema::dropIfExists('tbl_paket');
    }
}
