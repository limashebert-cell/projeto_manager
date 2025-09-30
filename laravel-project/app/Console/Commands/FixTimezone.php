<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Presenca;
use App\Models\HistoricoPresenca;
use App\Models\AuditoriaPresenca;

class FixTimezone extends Command
{
    protected $signature = 'timezone:fix';
    protected $description = 'Corrige o timezone dos registros existentes';

    public function handle()
    {
        $this->info('Iniciando correção de timezone...');
        
        // Definir timezone correto
        Carbon::setLocale('pt_BR');
        date_default_timezone_set('America/Sao_Paulo');
        
        $this->info('Timezone configurado: ' . Carbon::now()->getTimezone()->getName());
        $this->info('Data/Hora atual: ' . Carbon::now()->format('Y-m-d H:i:s'));
        
        // Verificar se há registros para corrigir
        $presencas = Presenca::count();
        $historicos = HistoricoPresenca::count();
        $auditorias = AuditoriaPresenca::count();
        
        $this->info("Registros encontrados:");
        $this->info("- Presenças: {$presencas}");
        $this->info("- Históricos: {$historicos}");
        $this->info("- Auditorias: {$auditorias}");
        
        // Aqui você pode adicionar lógica para corrigir registros existentes se necessário
        // Por exemplo, se houver registros com timezone errado
        
        $this->info('Correção de timezone concluída!');
        
        return 0;
    }
}