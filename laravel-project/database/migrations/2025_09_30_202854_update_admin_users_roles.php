<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateAdminUsersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primeiro, adicionar os novos valores incluindo o antigo 'admin'
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'admin', 'gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04') DEFAULT 'gestor'");
        
        // Depois, atualizar usuários com role 'admin' para 'gestor'
        DB::statement("UPDATE admin_users SET role = 'gestor' WHERE role = 'admin'");
        
        // Por fim, remover 'admin' do enum
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04') DEFAULT 'gestor'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Primeiro, adicionar 'admin' de volta ao enum
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'admin', 'gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04') DEFAULT 'admin'");
        
        // Depois voltar usuários com novos roles para 'admin' 
        DB::statement("UPDATE admin_users SET role = 'admin' WHERE role IN ('gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04')");
        
        // Por fim, reverter para o enum original
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'admin') DEFAULT 'admin'");
    }
}
