<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixColaboradoresCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:colaboradores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica e corrige dados de colaboradores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Verificando colaboradores...');
        
        // Buscar colaboradores sem admin_user_id ou com admin_user_id inválido
        $colaboradores = \App\Models\Colaborador::whereNull('admin_user_id')
            ->orWhereNotIn('admin_user_id', \App\Models\AdminUser::pluck('id'))
            ->get();
        
        if ($colaboradores->isEmpty()) {
            $this->info('Todos os colaboradores estão corretos!');
            return 0;
        }
        
        $this->warn("Encontrados {$colaboradores->count()} colaboradores com problema:");
        
        foreach ($colaboradores as $colaborador) {
            $this->line("ID: {$colaborador->id} - Nome: {$colaborador->nome} - AdminID: {$colaborador->admin_user_id}");
        }
        
        // Pegar o primeiro admin user para associar
        $firstAdmin = \App\Models\AdminUser::first();
        
        if ($firstAdmin && $this->confirm("Deseja associar todos ao admin '{$firstAdmin->name}' (ID: {$firstAdmin->id})?")) {
            foreach ($colaboradores as $colaborador) {
                $colaborador->update(['admin_user_id' => $firstAdmin->id]);
                $this->info("Colaborador {$colaborador->nome} associado ao admin {$firstAdmin->name}");
            }
        }
        
        return 0;
    }
}
