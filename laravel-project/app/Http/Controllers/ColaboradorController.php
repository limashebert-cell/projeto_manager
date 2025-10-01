<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode ver todos os colaboradores, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaboradores = Colaborador::with('adminUser')->paginate(10);
        } else {
            $colaboradores = $user->colaboradores()->with('adminUser')->paginate(10);
        }
        
        return view('admin.colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        return view('admin.colaboradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prontuario' => 'required|string|max:50|unique:colaboradores,prontuario',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:colaboradores,email',
            'telefone' => 'nullable|string|max:255',
            'data_admissao' => 'required|date',
            'contato' => 'required|string|max:255',
            'data_aniversario' => 'required|date',
            'cargo' => 'required|in:Auxiliar,Conferente,Adm,Op Empilhadeira',
            'status' => 'required|in:ativo,inativo',
            'tipo_inatividade' => 'nullable|required_if:status,inativo|in:afastado,desligado'
        ]);

        $adminUser = Auth::guard('admin')->user();
        
        $colaborador = new Colaborador($request->all());
        $colaborador->admin_user_id = $adminUser->id;
        $colaborador->save();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador cadastrado com sucesso!');
    }

    public function show($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode ver qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::with('adminUser')->findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->with('adminUser')->findOrFail($id);
        }
        
        return view('admin.colaboradores.show', compact('colaborador'));
    }

    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode editar qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::with('adminUser')->findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->with('adminUser')->findOrFail($id);
        }
        
        return view('admin.colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode atualizar qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->findOrFail($id);
        }
        
        $request->validate([
            'prontuario' => 'required|string|max:50|unique:colaboradores,prontuario,' . $colaborador->id,
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:colaboradores,email,' . $colaborador->id,
            'telefone' => 'nullable|string|max:255',
            'data_admissao' => 'required|date',
            'contato' => 'required|string|max:255',
            'data_aniversario' => 'required|date',
            'cargo' => 'required|in:Auxiliar,Conferente,Adm,Op Empilhadeira',
            'status' => 'required|in:ativo,inativo',
            'tipo_inatividade' => 'nullable|required_if:status,inativo|in:afastado,desligado'
        ]);

        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        
        // Super Admin pode excluir qualquer colaborador, outros users só os seus
        if ($user->isSuperAdmin()) {
            $colaborador = Colaborador::findOrFail($id);
        } else {
            $colaborador = $user->colaboradores()->findOrFail($id);
        }
        
        $colaborador->delete();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador removido com sucesso!');
    }

    /**
     * Download do template CSV para importação
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_colaboradores.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalhos do CSV
            fputcsv($file, [
                'prontuario',
                'nome',
                'email',
                'telefone',
                'data_admissao',
                'contato',
                'data_aniversario',
                'cargo',
                'status',
                'tipo_inatividade'
            ], ';');
            
            // Linha de exemplo
            fputcsv($file, [
                '123456',
                'João da Silva',
                'joao.silva@email.com',
                '(11) 99999-9999',
                '2023-01-15',
                '(11) 88888-8888',
                '1990-05-20',
                'Auxiliar',
                'ativo',
                ''
            ], ';');
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mostrar formulário de importação
     */
    public function showImport()
    {
        return view('admin.colaboradores.import');
    }

    /**
     * Processar importação de colaboradores
     */
    public function import(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $adminUser = Auth::guard('admin')->user();
        $arquivo = $request->file('arquivo');
        $atualizarExistentes = $request->has('atualizar_existentes');
        
        $importados = 0;
        $atualizados = 0;
        $erros = [];
        
        try {
            $handle = fopen($arquivo->getRealPath(), 'r');
            
            // Ler cabeçalho
            $cabecalho = fgetcsv($handle, 1000, ';');
            
            // Verificar se tem BOM e remover se necessário
            if (!empty($cabecalho[0])) {
                $cabecalho[0] = preg_replace('/\x{FEFF}/u', '', $cabecalho[0]);
            }
            
            $linha = 1;
            while (($dados = fgetcsv($handle, 1000, ';')) !== false) {
                $linha++;
                
                // Pular linhas vazias
                if (empty(array_filter($dados))) {
                    continue;
                }
                
                try {
                    // Mapear dados
                    $dadosColaborador = [];
                    foreach ($cabecalho as $index => $campo) {
                        $dadosColaborador[$campo] = $dados[$index] ?? '';
                    }
                    
                    // Validar campos obrigatórios
                    if (empty($dadosColaborador['prontuario']) || 
                        empty($dadosColaborador['nome']) ||
                        empty($dadosColaborador['email']) ||
                        empty($dadosColaborador['data_admissao']) ||
                        empty($dadosColaborador['cargo']) ||
                        empty($dadosColaborador['status'])) {
                        
                        $erros[] = "Linha {$linha}: Campos obrigatórios em branco (prontuario, nome, email, data_admissao, cargo, status)";
                        continue;
                    }
                    
                    // Verificar se colaborador já existe
                    $colaboradorExistente = Colaborador::where('prontuario', $dadosColaborador['prontuario'])
                                                     ->where('admin_user_id', $adminUser->id)
                                                     ->first();
                    
                    if ($colaboradorExistente) {
                        if ($atualizarExistentes) {
                            // Atualizar colaborador existente
                            $colaboradorExistente->update([
                                'nome' => $dadosColaborador['nome'],
                                'email' => $dadosColaborador['email'] ?? $colaboradorExistente->email,
                                'telefone' => $dadosColaborador['telefone'] ?? $colaboradorExistente->telefone,
                                'data_admissao' => $dadosColaborador['data_admissao'],
                                'contato' => $dadosColaborador['contato'] ?? $colaboradorExistente->contato,
                                'data_aniversario' => $dadosColaborador['data_aniversario'] ?? $colaboradorExistente->data_aniversario,
                                'cargo' => $dadosColaborador['cargo'],
                                'status' => $dadosColaborador['status'],
                                'tipo_inatividade' => $dadosColaborador['tipo_inatividade'] ?? null,
                            ]);
                            $atualizados++;
                        } else {
                            $erros[] = "Linha {$linha}: Colaborador com prontuário {$dadosColaborador['prontuario']} já existe";
                        }
                        continue;
                    }
                    
                    // Criar novo colaborador
                    Colaborador::create([
                        'prontuario' => $dadosColaborador['prontuario'],
                        'nome' => $dadosColaborador['nome'],
                        'email' => $dadosColaborador['email'] ?? '',
                        'telefone' => $dadosColaborador['telefone'] ?? null,
                        'data_admissao' => $dadosColaborador['data_admissao'],
                        'contato' => $dadosColaborador['contato'] ?? '',
                        'data_aniversario' => $dadosColaborador['data_aniversario'] ?? null,
                        'cargo' => $dadosColaborador['cargo'],
                        'status' => $dadosColaborador['status'],
                        'tipo_inatividade' => $dadosColaborador['tipo_inatividade'] ?? null,
                        'admin_user_id' => $adminUser->id,
                    ]);
                    
                    $importados++;
                    
                } catch (\Exception $e) {
                    $erros[] = "Linha {$linha}: Erro ao processar dados - " . $e->getMessage();
                }
            }
            
            fclose($handle);
            
            // Preparar mensagem de sucesso
            $mensagem = "Importação concluída! ";
            if ($importados > 0) {
                $mensagem .= "{$importados} colaborador(es) importado(s). ";
            }
            if ($atualizados > 0) {
                $mensagem .= "{$atualizados} colaborador(es) atualizado(s). ";
            }
            
            if (!empty($erros)) {
                return redirect()->route('colaboradores.import')
                    ->with('import_errors', $erros)
                    ->with('success', $mensagem);
            }
            
            return redirect()->route('colaboradores.index')
                ->with('success', $mensagem);
                
        } catch (\Exception $e) {
            return redirect()->route('colaboradores.import')
                ->with('error', 'Erro ao processar arquivo: ' . $e->getMessage());
        }
    }
}
