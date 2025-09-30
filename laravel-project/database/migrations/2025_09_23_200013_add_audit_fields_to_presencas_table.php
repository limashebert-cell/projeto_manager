<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditFieldsToPresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            // Campos de auditoria para registrar quando o gestor salva as informações
            $table->unsignedBigInteger('registrado_por')->nullable()->after('observacoes'); // Quem registrou (admin_user_id)
            $table->timestamp('data_hora_registro')->nullable()->after('registrado_por'); // Data e hora exata do registro
            $table->json('detalhes_registro')->nullable()->after('data_hora_registro'); // Detalhes do que foi registrado
            $table->string('ip_address')->nullable()->after('detalhes_registro'); // IP de onde foi registrado
            $table->text('user_agent')->nullable()->after('ip_address'); // Browser/dispositivo usado
            
            // Chave estrangeira para o usuário que fez o registro
            $table->foreign('registrado_por')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            // Remove os campos de auditoria
            $table->dropForeign(['registrado_por']);
            $table->dropColumn([
                'registrado_por',
                'data_hora_registro', 
                'detalhes_registro',
                'ip_address',
                'user_agent'
            ]);
        });
    }
}
