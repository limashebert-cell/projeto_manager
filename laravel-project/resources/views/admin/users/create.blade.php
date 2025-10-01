@extends('layouts.app')

@section('title', 'Adicionar Novo Usuário')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Adicionar Novo Usuário</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirmar Senha:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="area">Área:</label>
                            <input type="text" name="area" id="area" class="form-control" value="{{ old('area') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="role">Role:</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Selecione uma role</option>
                                <option value="admin">Admin</option>
                                <option value="gerente">Gerente</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="lider">Líder</option>
                                <option value="colaborador">Colaborador</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nivel">Nível:</label>
                            <select name="nivel" id="nivel" class="form-control" required>
                                <option value="">Selecione um nível</option>
                                <option value="Operacional">Operacional</option>
                                <option value="Tático">Tático</option>
                                <option value="Gestor">Gestor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection