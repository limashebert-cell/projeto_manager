<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RecreatePresencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Salvar dados existentes
        $existingData = DB::table('presencas')->get();
        
        // Remover tabela atual
        Schema::dropIfExists('presencas');
        
        // Recriar tabela com estrutura correta
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id'); // Corrigido para admin_user_id
            $table->unsignedBigInteger('colaborador_id'); 
            $table->date('data'); 
            $table->enum('status', ['presente', 'falta', 'atestado', 'banco_horas'])->default('presente');
            $table->text('observacoes')->nullable(); 
            $table->timestamps();
            
            // Chaves estrangeiras corretas
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            
            // Índice único para evitar duplicatas por dia
            $table->unique(['colaborador_id', 'data']);
        });
        
        // Restaurar dados com a coluna corrigida
        foreach ($existingData as $data) {
            DB::table('presencas')->insert([
                'id' => $data->id,
                'admin_user_id' => $data->user_id, // Mapear user_id para admin_user_id
                'colaborador_id' => $data->colaborador_id,
                'data' => $data->data,
                'status' => $data->status,
                'observacoes' => $data->observacoes,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Salvar dados existentes
        $existingData = DB::table('presencas')->get();
        
        // Remover tabela atual
        Schema::dropIfExists('presencas');
        
        // Recriar tabela com estrutura original (incorreta)
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Volta para user_id
            $table->unsignedBigInteger('colaborador_id'); 
            $table->date('data'); 
            $table->enum('status', ['presente', 'falta', 'atestado', 'banco_horas'])->default('presente');
            $table->text('observacoes')->nullable(); 
            $table->timestamps();
            
            // Chaves estrangeiras originais
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onDelete('cascade');
            
            // Índice único para evitar duplicatas por dia
            $table->unique(['colaborador_id', 'data']);
        });
        
        // Restaurar dados com a coluna original
        foreach ($existingData as $data) {
            DB::table('presencas')->insert([
                'id' => $data->id,
                'user_id' => $data->admin_user_id, // Mapear de volta
                'colaborador_id' => $data->colaborador_id,
                'data' => $data->data,
                'status' => $data->status,
                'observacoes' => $data->observacoes,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
        }
    }
}
