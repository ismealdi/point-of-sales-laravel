<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasukInventorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masuk_inventoris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventori', false)->unsigned()->nullable()->default(0);
            $table->foreign('inventori')->references('id')->on('inventoris');
            $table->integer('produk', false)->unsigned()->nullable()->default(0);
            $table->foreign('produk')->references('id')->on('produks');
            $table->integer('satuan', false)->unsigned();
            $table->foreign('satuan')->references('id')->on('satuans');
            $table->char('harga', 20)->default(0);
            $table->char('jumlah', 20)->default(0);
            $table->char('total', 20)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masuk_inventoris');
    }
}
