<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxAbsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_absen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik',20)->nullable();
            $table->string('nama',50)->nullable();
            $table->date('tanggal');
            $table->string('status',2)->nullable();
            $table->string('user_at',20)->nullable();
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
        Schema::dropIfExists('trx_absen');
    }
}
