<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAdminRoleTemporarily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adicionar 'admin' temporariamente para compatibilidade
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'admin', 'gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04') DEFAULT 'gestor'");
        
        // Converter qualquer 'admin' para 'gestor'
        DB::statement("UPDATE admin_users SET role = 'gestor' WHERE role = 'admin'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remover 'admin' do enum
        DB::statement("ALTER TABLE admin_users MODIFY COLUMN role ENUM('super_admin', 'gerente', 'gestor', 'administrativo', 'prevencao', 'sesmit', 'agente_01', 'agente_02', 'agente_03', 'agente_04') DEFAULT 'gestor'");
    }
}
