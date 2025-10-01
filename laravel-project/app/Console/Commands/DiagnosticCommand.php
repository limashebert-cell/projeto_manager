<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DiagnosticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnostic:colaboradores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnóstico da relação entre AdminUsers e Colaboradores';

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
        $this->info('=== DIAGNÓSTICO COLABORADORES ===');
        
        // AdminUsers
        $admins = \App\Models\AdminUser::all();
        $this->info("Total AdminUsers: " . $admins->count());
        
        foreach ($admins as $admin) {
            $colaboradores = $admin->colaboradores;
            $this->line("Admin: {$admin->name} (ID: {$admin->id}) - Colaboradores: {$colaboradores->count()}");
            
            foreach ($colaboradores as $colaborador) {
                $this->line("  - {$colaborador->nome} (ID: {$colaborador->id}, admin_user_id: {$colaborador->admin_user_id})");
            }
        }
        
        // Colaboradores órfãos
        $orfaos = \App\Models\Colaborador::whereNull('admin_user_id')->get();
        if ($orfaos->count() > 0) {
            $this->warn("Colaboradores órfãos (sem admin_user_id): " . $orfaos->count());
            foreach ($orfaos as $orfao) {
                $this->line("  - {$orfao->nome} (ID: {$orfao->id})");
            }
        }
        
        return 0;
    }
}
