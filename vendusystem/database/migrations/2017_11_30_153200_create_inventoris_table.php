<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('inventoris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('toko', false)->unsigned()->nullable()->default(0);
            $table->foreign('toko')->references('id')->on('tokos');
            $table->integer('user', false)->unsigned()->nullable()->default(0);
            $table->foreign('user')->references('id')->on('users');
            $table->integer('pemasok', false)->unsigned()->nullable()->default(0);
            $table->foreign('pemasok')->references('id')->on('pemasoks');
            $table->date('tanggal');
            $table->string('catatan')->nullable();
            $table->enum('transaksi', ['masuk', 'keluar', 'sirkulasi', 'koreksi', 'retur'])->default('masuk');
            $table->enum('po', [0,1])->default(0);
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
        Schema::dropIfExists('inventoris');
    }
}
