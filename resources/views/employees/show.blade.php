@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $employee->first_name }} {{ $employee->last_name }}</h1>

        <ul>
            <li>Email: {{ $employee->email }}</li>
            <li>Company: {{ $employee->company->name }}</li>
            <li>Phone: {{ $employee->phone }}</li>
        </ul>

        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection