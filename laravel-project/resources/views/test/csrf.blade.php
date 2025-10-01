@extends('layouts.app')

@section('title', 'Teste de CSRF')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Teste de CSRF Token</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('test.csrf') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="test_field" class="form-label">Campo de Teste</label>
                            <input type="text" class="form-control" id="test_field" name="test_field" value="teste">
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                Token CSRF: {{ csrf_token() }}
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                Session ID: {{ session()->getId() }}
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Testar CSRF</button>
                    </form>
                    
                    @if(session('test_result'))
                        <div class="alert alert-success mt-3">
                            {{ session('test_result') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection