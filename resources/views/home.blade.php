
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @auth
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    
                    <div class="mt-3">
                        <a href="{{ route('companies.index') }}" class="btn btn-primary">Company</a>
                        <a href="{{ route('employees.index') }}" class="btn btn-success">Employee</a>
                    </div>
                   
                </div>

            @else

            <div class="card">           
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are not logged in!') }}

                    
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    </div>
                   
                </div>
            </div>

                
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection


