<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPresencasForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            // Remover a chave estrangeira atual
            $table->dropForeign(['user_id']);
            
            // Renomear a coluna de user_id para admin_user_id
            $table->renameColumn('user_id', 'admin_user_id');
            
            // Adicionar a nova chave estrangeira para admin_users
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
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
            // Remover a chave estrangeira nova
            $table->dropForeign(['admin_user_id']);
            
            // Renomear de volta para user_id
            $table->renameColumn('admin_user_id', 'user_id');
            
            // Restaurar a chave estrangeira original
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
