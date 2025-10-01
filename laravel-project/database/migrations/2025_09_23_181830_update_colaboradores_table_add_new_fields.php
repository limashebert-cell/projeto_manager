<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColaboradoresTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Como os campos foram removidos em migrações anteriores, 
        // apenas garantimos que os novos campos existam
        Schema::table('colaboradores', function (Blueprint $table) {
            // Verificar se as colunas já existem antes de adicionar
            if (!Schema::hasColumn('colaboradores', 'prontuario')) {
                $table->string('prontuario')->nullable()->after('admin_user_id');
            }
            if (!Schema::hasColumn('colaboradores', 'data_admissao')) {
                $table->date('data_admissao')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('colaboradores', 'contato')) {
                $table->string('contato')->nullable()->after('data_admissao');
            }
            if (!Schema::hasColumn('colaboradores', 'data_aniversario')) {
                $table->date('data_aniversario')->nullable()->after('contato');
            }
            if (!Schema::hasColumn('colaboradores', 'cargo')) {
                $table->enum('cargo', ['Auxiliar', 'Conferente', 'Adm', 'Op Empilhadeira'])->nullable()->after('data_aniversario');
            }
        });
    }

    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            // Restaurar campos removidos
            $table->string('email')->unique()->after('nome');
            $table->string('telefone')->nullable()->after('email');
            
            // Remover novos campos
            $table->dropColumn(['prontuario', 'data_admissao', 'contato', 'data_aniversario']);
            
            // Restaurar campo cargo original
            $table->dropColumn('cargo');
        });
        
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('telefone');
        });
    }
}
