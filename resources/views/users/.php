@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Users Listing</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Mobile</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adminUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
