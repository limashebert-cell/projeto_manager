<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeclockRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'date',
        'clock_in',
        'clock_out',
        'break_start',
        'break_end',
        'notes',
        'total_hours'
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime:H:i',
        'clock_out' => 'datetime:H:i',
        'break_start' => 'datetime:H:i',
        'break_end' => 'datetime:H:i',
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

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function calculateTotalHours()
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = Carbon::createFromFormat('H:i', $this->clock_in);
            $clockOut = Carbon::createFromFormat('H:i', $this->clock_out);
            
            $totalMinutes = $clockOut->diffInMinutes($clockIn);
            
            // Subtrair tempo de intervalo se houver
            if ($this->break_start && $this->break_end) {
                $breakStart = Carbon::createFromFormat('H:i', $this->break_start);
                $breakEnd = Carbon::createFromFormat('H:i', $this->break_end);
                $breakMinutes = $breakEnd->diffInMinutes($breakStart);
                $totalMinutes -= $breakMinutes;
            }
            
            $this->total_hours = round($totalMinutes / 60, 2);
            $this->save();
        }
    }

    public function getFormattedTotalHoursAttribute()
    {
        if ($this->total_hours) {
            $hours = floor($this->total_hours);
            $minutes = ($this->total_hours - $hours) * 60;
            return sprintf('%02d:%02d', $hours, $minutes);
        }
        return '--:--';
    }
}
