<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToQuaseAcidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quase_acidentes', function (Blueprint $table) {
            $table->string('imagem_1')->nullable()->after('acoes_tomadas');
            $table->string('imagem_2')->nullable()->after('imagem_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quase_acidentes', function (Blueprint $table) {
            $table->dropColumn(['imagem_1', 'imagem_2']);
        });
    }
}
