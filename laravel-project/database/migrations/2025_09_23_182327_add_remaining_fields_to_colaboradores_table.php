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
            $table->string('prontuario')->nullable()->after('admin_user_id');
            $table->date('data_admissao')->nullable()->after('nome');
            $table->string('contato')->nullable()->after('data_admissao');
            $table->date('data_aniversario')->nullable()->after('contato');
            $table->enum('cargo', ['Auxiliar', 'Conferente', 'Adm', 'Op Empilhadeira'])->nullable()->after('data_aniversario');
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
