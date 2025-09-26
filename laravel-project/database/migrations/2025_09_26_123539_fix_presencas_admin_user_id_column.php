<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixPresencasAdminUserIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verificar se a coluna admin_user_id já existe
        if (!Schema::hasColumn('presencas', 'admin_user_id')) {
            // Adicionar a nova coluna
            Schema::table('presencas', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_user_id')->nullable()->after('id');
            });
            
            // Copiar dados de user_id para admin_user_id
            DB::statement('UPDATE presencas SET admin_user_id = user_id');
            
            // Tornar admin_user_id not null
            Schema::table('presencas', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_user_id')->nullable(false)->change();
            });
            
            // Adicionar chave estrangeira
            Schema::table('presencas', function (Blueprint $table) {
                $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remover chave estrangeira e coluna admin_user_id
        if (Schema::hasColumn('presencas', 'admin_user_id')) {
            Schema::table('presencas', function (Blueprint $table) {
                $table->dropColumn('admin_user_id');
            });
        }
    }
}
