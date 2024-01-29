@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $company->name }}</h1>

        <table class="table">
            <tbody>
                <tr>
                    <th>Email:</th>
                    <td>{{ $company->email }}</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td>{{ $company->address }}</td>
                </tr>
                <tr>
                    <th>Logo:</th>
                    <td>
                        @if($company->logo)
                            <img src="{{ asset($company->logo) }}" alt="Company Logo" width="100" height="100">
                        @else
                            No Logo
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Website:</th>
                    <td>{{ $company->website }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
