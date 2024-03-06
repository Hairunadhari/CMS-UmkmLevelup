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
        Schema::create('martikels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artikel_id')->nullable();
            $table->unsignedBigInteger('materi_artikel_id')->nullable();
            $table->bigInteger('status')->default(1);

            $table->foreign('materi_artikel_id')->references('id')->on('materi_artikels');
            $table->foreign('artikel_id')->references('id')->on('artikels');
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
        Schema::dropIfExists('martikels');
    }
};
