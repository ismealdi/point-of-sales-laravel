<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('daftar_produks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paket', false)->unsigned()->nullable()->default(0);
            $table->foreign('paket')->references('id')->on('paket_produks');
            $table->integer('produk', false)->unsigned()->nullable()->default(0);
            $table->foreign('produk')->references('id')->on('produks');
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
        Schema::dropIfExists('daftar_produks');
    }
}
