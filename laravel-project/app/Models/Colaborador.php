<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;
    
    protected $table = 'colaboradores';
    
    protected $fillable = [
        'admin_user_id',
        'prontuario',
        'nome',
        'email',
        'telefone',
        'data_admissao',
        'contato',
        'data_aniversario',
        'cargo',
        'status'
    ];
    
    protected $dates = [
        'data_admissao',
        'data_aniversario'
    ];
    
    // Relacionamento com o usuário admin (proprietário)
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
    
    // Relacionamento com presenças
    public function presencas()
    {
        return $this->hasMany(Presenca::class);
    }
    
    // Scope para colaboradores ativos
    public function scopeAtivo($query)
    {
        return $query->where('status', 'ativo');
    }
}
