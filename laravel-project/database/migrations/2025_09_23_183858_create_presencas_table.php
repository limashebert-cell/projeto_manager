<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Quem está registrando
            $table->unsignedBigInteger('colaborador_id'); // Colaborador sendo registrado
            $table->date('data'); // Data do registro
            $table->enum('status', ['presente', 'falta', 'atestado', 'banco_horas'])->default('presente');
            $table->text('observacoes')->nullable(); // Observações adicionais
            $table->timestamps();
            
            // Chaves estrangeiras
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            
            // Índice único para evitar duplicatas por dia
            $table->unique(['colaborador_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presencas');
    }
}
