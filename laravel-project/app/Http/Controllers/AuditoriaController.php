<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditoriaPresenca;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', now()->format('Y-m-d'));
        
        $auditorias = AuditoriaPresenca::with('adminUser')
            ->where('admin_user_id', Auth::id())
            ->whereBetween('data_registro', [$dataInicio, $dataFim])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.auditoria.index', compact('auditorias', 'dataInicio', 'dataFim'));
    }
    
    public function show($id)
    {
        $auditoria = AuditoriaPresenca::with('adminUser')
            ->where('admin_user_id', Auth::id())
            ->findOrFail($id);
            
        return view('admin.auditoria.show', compact('auditoria'));
    }
}
