<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrechosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trechos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("verbete_id");
            $table->string("titulo_video");
            $table->string("tipo_recurso");
            $table->string("tempo");
            $table->string("endereco_video");
            $table->text("texto");
            $table->string("arquivo_hd")->nullable();
            $table->string("arquivo_sd")->nullable();
            $table->integer("quant_views");
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
        Schema::dropIfExists('trechos');
    }
}
