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
    
    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class);
    }
}
