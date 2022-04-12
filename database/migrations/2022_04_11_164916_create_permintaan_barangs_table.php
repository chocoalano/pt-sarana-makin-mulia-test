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
        Schema::create('permintaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_id')->unsigned()->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->integer('qty');
            $table->longText('keterangan');
            $table->string('status',20);
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
        Schema::dropIfExists('permintaan_barangs');
    }
};
