<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendonoransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendonorans', function (Blueprint $table) {
            $table->string('no_pendonoran')->primary();
            $table->dateTime('waktu_donor');
            $table->string('location');
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('pendonoran_ke');
            $table->string('petugas_periksa');
            $table->double('hemoglobin');
            $table->integer('berat_badan');
            $table->string('tensi');
            $table->integer('cc_diambil');
            $table->date('kembali_setelah');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendonorans');
    }
}
