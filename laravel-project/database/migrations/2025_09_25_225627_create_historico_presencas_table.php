<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoPresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id'); // Quem registrou
            $table->unsignedBigInteger('colaborador_id'); // Colaborador
            $table->date('data_presenca'); // Data da presença registrada
            $table->enum('status_anterior', ['presente', 'falta', 'atestado', 'banco_horas'])->nullable(); // Status anterior (null para novo registro)
            $table->enum('status_novo', ['presente', 'falta', 'atestado', 'banco_horas']); // Novo status
            $table->text('observacoes_anterior')->nullable(); // Observações anteriores
            $table->text('observacoes_nova')->nullable(); // Novas observações
            $table->enum('acao', ['criado', 'editado', 'excluido']); // Tipo de ação
            $table->string('ip_address')->nullable(); // IP de quem fez a alteração
            $table->text('user_agent')->nullable(); // User agent
            $table->json('dados_completos')->nullable(); // Dados completos do registro para auditoria
            $table->timestamps(); // created_at = momento do registro no histórico
            
            // Chaves estrangeiras
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            
            // Índices para consultas rápidas
            $table->index(['colaborador_id', 'data_presenca']);
            $table->index(['admin_user_id', 'created_at']);
            $table->index('data_presenca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_presencas');
    }
}
