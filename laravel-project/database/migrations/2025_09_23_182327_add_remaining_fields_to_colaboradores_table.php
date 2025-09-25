<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingFieldsToColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn(['prontuario', 'data_admissao', 'contato', 'data_aniversario', 'cargo']);
        });
    }
}
