<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeEmailNullableInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            // Tornar o campo email nullable
            $table->string('email')->nullable()->change();
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
            // Voltar o campo email para NOT NULL
            $table->string('email')->nullable(false)->change();
        });
    }
}
