<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemiliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('pemiliks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user', false)->unsigned()->nullable();
            $table->foreign('user')->references('id')->on('users');
            $table->integer('toko', false)->unsigned();
            $table->foreign('toko')->references('id')->on('tokos');
            $table->string('nama');
            $table->char('telepon', 12)->default(0)->nullabe();
            $table->string('alamat')->nullable();
            $table->enum('status', [0,1])->default(1);
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
        Schema::dropIfExists('pemiliks');
    }
}
