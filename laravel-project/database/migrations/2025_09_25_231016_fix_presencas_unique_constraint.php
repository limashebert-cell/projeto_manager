<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPresencasUniqueConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            // Remover constraint atual que causa problemas
            $table->dropUnique(['colaborador_id', 'data']);
            
            // Adicionar nova constraint mais adequada que inclui admin_user_id
            $table->unique(['admin_user_id', 'colaborador_id', 'data'], 'presencas_admin_colaborador_data_unique');
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
            // Remover nova constraint
            $table->dropUnique('presencas_admin_colaborador_data_unique');
            
            // Restaurar constraint original
            $table->unique(['colaborador_id', 'data']);
        });
    }
}
