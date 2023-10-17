@extends('layouts.app')

@section('content')
               
<div class="container">
    <h1>Manage Permissions</h1>
    <p>Here you can manage user permissions.</p>

    <div class="container">
    <form id="permissionsForm" action="{{ route('permissions.store') }}" method="post">
    @csrf
    <label>Create a New Role:</label>
    <input type="text" name="name" placeholder="Create a new role" required>
    </div>
    <div class="table-responsive">
    <table class="table ">
        <thead>
            <tr>
                <th>S.No</th> 
                <th>Name</th>
                <th>Guard Name</th>
                <th>Assign</th>
            </tr>
            </div>
        </thead>

        @if(session('success'))
   <div id="success-message" class="alert alert-success">
       {{ session('success') }}
   </div>
   <script>
       setTimeout(function() {
           $('#success-message').fadeOut();
       }, 2000);
   </script>
@endif
        <tbody>
            @php
                $count = 1; // Initialize the serial number
            @endphp
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $count++ }}</td> 
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
   <button type="button" class="btn btn-success"  onclick="myfun()">Create & Assign Role</button>
</form>
</div>

<script>
    function myfun() {
        if (confirm('Are you sure you want to create a new role for this user?')) {
            document.getElementById('permissionsForm').submit();
        } else {
            // User clicked "Cancel", do nothing
        }
    }
</script>
@endsection
