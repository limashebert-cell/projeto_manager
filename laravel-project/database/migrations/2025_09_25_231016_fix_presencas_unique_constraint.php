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
        // Para evitar erro 1553 (índice usado em FK), primeiro verificamos se o índice existe
        // e usamos SQL bruto para removê-lo de forma segura, depois adicionamos o novo se ainda não existir.
        if (Schema::hasTable('presencas')) {
            $connection = Schema::getConnection();
            $schemaManager = $connection->getDoctrineSchemaManager();
            $indexes = $schemaManager->listTableIndexes('presencas');

            // Não remover o índice antigo porque ele sustenta a FK em colaborador_id.
            // Apenas adicionar o novo índice composto se ainda não existir.
            if (!array_key_exists('presencas_admin_colaborador_data_unique', $indexes)) {
                Schema::table('presencas', function (Blueprint $table) {
                    $table->unique(['admin_user_id', 'colaborador_id', 'data'], 'presencas_admin_colaborador_data_unique');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('presencas')) {
            $connection = Schema::getConnection();
            $schemaManager = $connection->getDoctrineSchemaManager();
            $indexes = $schemaManager->listTableIndexes('presencas');

            // Remover apenas o índice novo se foi criado por esta migração.
            if (array_key_exists('presencas_admin_colaborador_data_unique', $indexes)) {
                $connection->statement('ALTER TABLE presencas DROP INDEX presencas_admin_colaborador_data_unique');
            }
            // Não recriamos o antigo pois nunca foi removido neste fluxo.
        }
    }
}
