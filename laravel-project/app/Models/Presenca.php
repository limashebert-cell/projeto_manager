<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presenca extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'admin_user_id',
        'colaborador_id', 
        'data',
        'status',
        'observacoes',
        'registrado_por',
        'data_hora_registro',
        'detalhes_registro',
        'ip_address',
        'user_agent'
    ];
    
    protected $dates = ['data', 'data_hora_registro'];
    
    protected $casts = [
        'data' => 'date',
        'data_hora_registro' => 'datetime',
        'detalhes_registro' => 'array'
    ];

    // Garantir que as datas usem o timezone correto
    protected function asDateTime($value)
    {
        if ($value === null) {
            return $value;
        }
        
        $datetime = parent::asDateTime($value);
        
        // Se já tem timezone, converte para o timezone da aplicação
        if ($datetime instanceof \Carbon\Carbon) {
            return $datetime->setTimezone(config('app.timezone'));
        }
        
        return $datetime;
    }
    
    // Relacionamentos
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }
    
    // Manter compatibilidade com código antigo
    public function user()
    {
        return $this->adminUser();
    }
    
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }
    
    public function registradoPor()
    {
        return $this->belongsTo(AdminUser::class, 'registrado_por');
    }
    
    // Scopes
    public function scopePorData($query, $data)
    {
        return $query->where('data', $data);
    }
    
    public function scopePorColaborador($query, $colaboradorId)
    {
        return $query->where('colaborador_id', $colaboradorId);
    }
    
    // Acessores
    public function getStatusFormatadoAttribute()
    {
        $status = [
            'presente' => 'Presente',
            'falta' => 'Falta',
            'atestado' => 'Atestado',
            'banco_horas' => 'Banco de Horas'
        ];
        
        return $status[$this->status] ?? $this->status;
    }
    
    public function getStatusCorAttribute()
    {
        $cores = [
            'presente' => 'success',
            'falta' => 'danger', 
            'atestado' => 'warning',
            'banco_horas' => 'info'
        ];
        
        return $cores[$this->status] ?? 'secondary';
    }
}
