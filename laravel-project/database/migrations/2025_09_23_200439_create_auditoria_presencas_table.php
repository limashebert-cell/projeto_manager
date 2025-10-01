<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriaPresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id'); // ID do gestor que salvou
            $table->date('data_registro'); // Data das presenças registradas
            $table->json('dados_presenca'); // Dados completos das presenças salvas
            $table->integer('total_colaboradores'); // Total de colaboradores
            $table->integer('total_presentes'); // Total de presentes
            $table->integer('total_ausentes'); // Total de ausentes
            $table->integer('total_justificados'); // Total de justificados
            $table->string('ip_address')->nullable(); // IP de onde foi salvo
            $table->text('observacoes')->nullable(); // Observações gerais
            $table->timestamps(); // created_at e updated_at
            
            // Índices para melhor performance
            $table->index(['admin_user_id', 'data_registro']);
            $table->index('data_registro');
            
            // Chave estrangeira
            $table->foreign('admin_user_id')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditoria_presencas');
    }
}
