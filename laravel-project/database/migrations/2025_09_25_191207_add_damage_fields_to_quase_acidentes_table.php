<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDamageFieldsToQuaseAcidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quase_acidentes', function (Blueprint $table) {
            $table->boolean('houve_dano_material')->default(false)->after('imagem_2');
            $table->boolean('houve_prejuizo')->default(false)->after('houve_dano_material');
            $table->decimal('valor_estimado', 10, 2)->nullable()->after('houve_prejuizo');
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
            $table->dropColumn(['houve_dano_material', 'houve_prejuizo', 'valor_estimado']);
        });
    }
}
