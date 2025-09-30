<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPresenca extends Model
{
    use HasFactory;
    
    protected $table = 'historico_presencas';
    
    protected $fillable = [
        'admin_user_id',
        'colaborador_id',
        'data_presenca',
        'status_anterior',
        'status_novo',
        'observacoes_anterior',
        'observacoes_nova',
        'acao',
        'ip_address',
        'user_agent',
        'dados_completos'
    ];
    
    protected $casts = [
        'data_presenca' => 'date',
        'dados_completos' => 'array'
    ];
    
    // Relacionamentos
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
    
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }
    
    // Scopes
    public function scopePorColaborador($query, $colaboradorId)
    {
        return $query->where('colaborador_id', $colaboradorId);
    }
    
    public function scopePorData($query, $data)
    {
        return $query->where('data_presenca', $data);
    }
    
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_presenca', [$dataInicio, $dataFim]);
    }
    
    // Métodos auxiliares
    public function getStatusAnteriorFormatado()
    {
        if (!$this->status_anterior) return 'Novo registro';
        
        $status = [
            'presente' => 'Presente',
            'falta' => 'Falta',
            'atestado' => 'Atestado',
            'banco_horas' => 'Banco de Horas'
        ];
        
        return $status[$this->status_anterior] ?? $this->status_anterior;
    }
    
    public function getStatusNovoFormatado()
    {
        $status = [
            'presente' => 'Presente',
            'falta' => 'Falta',
            'atestado' => 'Atestado',
            'banco_horas' => 'Banco de Horas'
        ];
        
        return $status[$this->status_novo] ?? $this->status_novo;
    }
    
    public function getAcaoFormatada()
    {
        $acoes = [
            'criado' => 'Criado',
            'editado' => 'Editado',
            'excluido' => 'Excluído'
        ];
        
        return $acoes[$this->acao] ?? $this->acao;
    }
}
