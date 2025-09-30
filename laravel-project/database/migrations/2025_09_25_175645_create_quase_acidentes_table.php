<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuaseAcidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quase_acidentes', function (Blueprint $table) {
            $table->id();
            $table->datetime('data_ocorrencia');
            $table->string('local');
            $table->text('descricao');
            $table->string('colaborador_envolvido')->nullable();
            $table->enum('gravidade', ['baixa', 'media', 'alta'])->default('baixa');
            $table->text('acoes_tomadas')->nullable();
            $table->enum('status', ['pendente', 'em_andamento', 'concluido'])->default('pendente');
            $table->unsignedBigInteger('responsavel_id');
            $table->foreign('responsavel_id')->references('id')->on('admin_users');
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
        Schema::dropIfExists('quase_acidentes');
    }
}
