<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Esta migração tornou-se redundante porque a coluna 'email' já existe na criação inicial da tabela.
        // Para evitar erro (Duplicate column) quando rodar em ambientes já migrados, verificamos antes.
        if (!Schema::hasColumn('colaboradores', 'email')) {
            Schema::table('colaboradores', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nome');
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
        if (Schema::hasColumn('colaboradores', 'email')) {
            Schema::table('colaboradores', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
}
