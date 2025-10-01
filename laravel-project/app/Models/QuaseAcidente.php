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
        'responsavel_id',
        'imagem_1',
        'imagem_2',
        'houve_dano_material',
        'houve_prejuizo',
        'valor_estimado'
    ];
    
    protected $casts = [
        'data_ocorrencia' => 'datetime',
        'houve_dano_material' => 'boolean',
        'houve_prejuizo' => 'boolean',
        'valor_estimado' => 'decimal:2',
    ];
    
    public function responsavel()
    {
        return $this->belongsTo(AdminUser::class, 'responsavel_id');
    }
}
