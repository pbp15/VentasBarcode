<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // ESTO PARA CLIENTES DE LAS VENTAS
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
         
            $table->integer('id')->unsigned();
            $table->string('phone',50)->nullable();            
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
