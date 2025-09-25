<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuaseAcidente extends Model
{
    use HasFactory;
    
    protected $table = 'quase_acidentes';
    
    protected $fillable = [
        'data_ocorrencia',
        'local',
        'descricao',
        'colaborador_envolvido',
        'gravidade',
        'acoes_tomadas',
        'status',
        'responsavel_id'
    ];
    
    protected $casts = [
        'data_ocorrencia' => 'datetime',
    ];
    
    public function responsavel()
    {
        return $this->belongsTo(AdminUser::class, 'responsavel_id');
    }
}
