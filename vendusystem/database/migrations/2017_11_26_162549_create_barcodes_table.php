<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('barcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('toko', false)->unsigned()->nullable()->default(0);
            $table->foreign('toko')->references('id')->on('tokos');
            $table->integer('produk', false)->unsigned()->nullable()->default(0);
            $table->foreign('produk')->references('id')->on('produks');
            $table->text('barcode');
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
        Schema::dropIfExists('barcodes');
    }
}
