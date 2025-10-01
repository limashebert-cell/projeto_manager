@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Usuário</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Nova Senha (deixe em branco para manter atual):</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirmar Nova Senha:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="area">Área:</label>
                            <input type="text" name="area" id="area" class="form-control" value="{{ old('area', $user->area) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="role">Role:</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Selecione uma role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="gerente" {{ old('role', $user->role) == 'gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="supervisor" {{ old('role', $user->role) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="lider" {{ old('role', $user->role) == 'lider' ? 'selected' : '' }}>Líder</option>
                                <option value="colaborador" {{ old('role', $user->role) == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nivel">Nível:</label>
                            <select name="nivel" id="nivel" class="form-control" required>
                                <option value="">Selecione um nível</option>
                                <option value="Operacional" {{ old('nivel', $user->nivel) == 'Operacional' ? 'selected' : '' }}>Operacional</option>
                                <option value="Tático" {{ old('nivel', $user->nivel) == 'Tático' ? 'selected' : '' }}>Tático</option>
                                <option value="Gestor" {{ old('nivel', $user->nivel) == 'Gestor' ? 'selected' : '' }}>Gestor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection