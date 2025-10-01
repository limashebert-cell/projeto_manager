<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'area',
        'role',
        'nivel',
        'active'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isGerente()
    {
        return $this->role === 'gerente';
    }

    public function isGestor()
    {
        return $this->role === 'gestor';
    }

    public function isAdministrativo()
    {
        return $this->role === 'administrativo';
    }

    public function isPrevencao()
    {
        return $this->role === 'prevencao';
    }

    public function isSesmit()
    {
        return $this->role === 'sesmit';
    }

    public function isAgente01()
    {
        return $this->role === 'agente_01';
    }

    public function isAgente02()
    {
        return $this->role === 'agente_02';
    }

    public function isAgente03()
    {
        return $this->role === 'agente_03';
    }

    public function isAgente04()
    {
        return $this->role === 'agente_04';
    }

    public function canManageUsers()
    {
        return $this->isSuperAdmin() || $this->isGerente();
    }

    public function getRoleName()
    {
        $roles = [
            'super_admin' => 'Super Administrador',
            'gerente' => 'Gerente',
            'gestor' => 'Gestor',
            'administrativo' => 'Administrativo',
            'prevencao' => 'Prevenção',
            'sesmit' => 'SESMIT',
            'agente_01' => 'Agente 01',
            'agente_02' => 'Agente 02',
            'agente_03' => 'Agente 03',
            'agente_04' => 'Agente 04'
        ];

        return $roles[$this->role] ?? 'Usuário';
    }

    public function isActive()
    {
        return $this->active;
    }

    public function timeclockRecords()
    {
        return $this->hasMany(TimeclockRecord::class);
    }

    public function todayTimeclockRecord()
    {
        return $this->hasOne(TimeclockRecord::class)->whereDate('date', today());
    }

    // Accessors para compatibilidade com a view
    public function getIsActiveAttribute()
    {
        return $this->active;
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->role === 'super_admin';
    }
    
    // Método para obter o nome do nível
    public function getNivelName()
    {
        return $this->nivel ?? 'Não definido';
    }
    
    // Método para verificar se tem um nível específico
    public function hasNivel($nivel)
    {
        return $this->nivel === $nivel;
    }
    
    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class, 'admin_user_id');
    }
}
