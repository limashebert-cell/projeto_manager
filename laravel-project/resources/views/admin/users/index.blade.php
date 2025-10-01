@extends('layouts.app')

@section('title', 'Gerenciar Usuários - Painel Administrativo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
    <h4>Usuários ({{ $users->count() }})</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Novo</a>
</div>

@if($users->count() > 0)
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Role</th>
                            <th>Nível</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $user->getRoleName() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $user->getNivelName() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->active ? 'success' : 'danger' }}">
                                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-info btn-sm">Ver</a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-warning btn-sm">Editar</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Excluir usuário?')">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center p-3">
            <p class="text-muted mb-2">Nenhum usuário cadastrado</p>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Criar Primeiro Usuário</a>
        </div>
    </div>
@endif

@endsection