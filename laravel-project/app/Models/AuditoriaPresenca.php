<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaPresenca extends Model
{
    use HasFactory;
    
    protected $table = 'auditoria_presencas';
    
    protected $fillable = [
        'admin_user_id',
        'data_registro',
        'dados_presenca',
        'total_colaboradores',
        'total_presentes',
        'total_ausentes',
        'total_justificados',
        'ip_address',
        'observacoes'
    ];
    
    protected $casts = [
        'data_registro' => 'date',
        'dados_presenca' => 'array',
        'total_colaboradores' => 'integer',
        'total_presentes' => 'integer',
        'total_ausentes' => 'integer',
        'total_justificados' => 'integer'
    ];
    
    /**
     * Relacionamento com o usuário admin que fez o registro
     */
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
    
    /**
     * Scope para buscar auditoria por data
     */
    public function scopePorData($query, $data)
    {
        return $query->where('data_registro', $data);
    }
    
    /**
     * Scope para buscar auditoria por gestor
     */
    public function scopePorGestor($query, $adminUserId)
    {
        return $query->where('admin_user_id', $adminUserId);
    }
}
