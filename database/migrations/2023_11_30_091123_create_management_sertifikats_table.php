<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitator')->nullable();
            $table->string('nama_usaha')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('aktif')->default(1);
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
        Schema::dropIfExists('management_sertifikats');
    }
};
