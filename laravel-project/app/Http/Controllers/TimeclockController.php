<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeclockRecord;
use Carbon\Carbon;

class TimeclockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $user = Auth::guard('admin')->user();
        $today = today();
        
        // Buscar o registro de hoje
        $todayRecord = TimeclockRecord::where('admin_user_id', $user->id)
                                     ->where('date', $today)
                                     ->first();
        
        // Buscar registros dos últimos 7 dias
        $recentRecords = TimeclockRecord::where('admin_user_id', $user->id)
                                       ->where('date', '>=', $today->subDays(6))
                                       ->orderBy('date', 'desc')
                                       ->get();
        
        return view('admin.timeclock.index', compact('todayRecord', 'recentRecords', 'user'));
    }

    public function clockIn(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $today = today();
        
        // Verificar se já tem registro para hoje
        $record = TimeclockRecord::firstOrCreate(
            [
                'admin_user_id' => $user->id,
                'date' => $today
            ],
            [
                'clock_in' => now()->format('H:i')
            ]
        );
        
        if (!$record->wasRecentlyCreated && !$record->clock_in) {
            $record->update(['clock_in' => now()->format('H:i')]);
        }
        
        return redirect()->route('admin.timeclock')
                        ->with('success', 'Entrada registrada com sucesso às ' . now()->format('H:i'));
    }

    public function clockOut(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $today = today();
        
        $record = TimeclockRecord::where('admin_user_id', $user->id)
                                ->where('date', $today)
                                ->first();
        
        if ($record) {
            $record->update(['clock_out' => now()->format('H:i')]);
            $record->calculateTotalHours();
            
            return redirect()->route('admin.timeclock')
                            ->with('success', 'Saída registrada com sucesso às ' . now()->format('H:i'));
        }
        
        return redirect()->route('admin.timeclock')
                        ->with('error', 'Você precisa registrar a entrada primeiro!');
    }

    public function startBreak(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $today = today();
        
        $record = TimeclockRecord::where('admin_user_id', $user->id)
                                ->where('date', $today)
                                ->first();
        
        if ($record) {
            $record->update(['break_start' => now()->format('H:i')]);
            
            return redirect()->route('admin.timeclock')
                            ->with('success', 'Início do intervalo registrado às ' . now()->format('H:i'));
        }
        
        return redirect()->route('admin.timeclock')
                        ->with('error', 'Você precisa registrar a entrada primeiro!');
    }

    public function endBreak(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $today = today();
        
        $record = TimeclockRecord::where('admin_user_id', $user->id)
                                ->where('date', $today)
                                ->first();
        
        if ($record && $record->break_start) {
            $record->update(['break_end' => now()->format('H:i')]);
            $record->calculateTotalHours();
            
            return redirect()->route('admin.timeclock')
                            ->with('success', 'Fim do intervalo registrado às ' . now()->format('H:i'));
        }
        
        return redirect()->route('admin.timeclock')
                        ->with('error', 'Você precisa iniciar o intervalo primeiro!');
    }

    public function updateNotes(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);
        
        $user = Auth::guard('admin')->user();
        $today = today();
        
        $record = TimeclockRecord::where('admin_user_id', $user->id)
                                ->where('date', $today)
                                ->first();
        
        if ($record) {
            $record->update(['notes' => $request->notes]);
            
            return redirect()->route('admin.timeclock')
                            ->with('success', 'Observações atualizadas com sucesso!');
        }
        
        return redirect()->route('admin.timeclock')
                        ->with('error', 'Registro não encontrado!');
    }
}
