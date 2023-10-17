@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Permissions</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/manpermissions/create" class="btn btn-outline-dark mb-3" style="background-color: #76A8C3;">Create New Permission</a>
        <div class="search-container">
            <a class="btn btn-outline-dark mb-3"   href="/manage-permission"  style="background-color: #76A8C3;">Create New Role </a>

    </div>
    </div>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Name</th>
                <th>Guard Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    $('#success-message').fadeOut();
                }, 1000);
            </script>
        @endif

        <tbody>
            @php
                $serialNumber = 1; 
            @endphp

            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $serialNumber++ }}</td> <!-- Increment the serial number for each row -->
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>
                        <form id="delete-form-{{$permission->id}}" action="manpermissions/{{$permission->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('{{$permission->id}}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                &nbsp;
                                <a href="permissions/{{$permission->id}}/edit" class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                          </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</div>

<script>
    function confirmDelete(permissionId) {
        if (confirm('Are you sure you want to delete this permission?')) {
            document.getElementById('delete-form-' + permissionId).submit();
        } else {
            // User clicked "Cancel", do nothing
        }
    }
</script>
@endsection