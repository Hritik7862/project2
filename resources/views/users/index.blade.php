  @extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Listing</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('register') }}" class="btn btn-outline mb-3" style="background-color: #79A5BE;">New User Create</a>
        <div class="search-container" >
            <input type="text" id="user-search" class="form-control" placeholder="Search users" style="background: rgba(255, 99, 71, 0);">
        </div>
    </div>
</div>
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
<script>
    setTimeout(function () {
        window.location.href = "{{ route('users.index') }}";
    }, 1000);
</script>
@endif
<div class="table-responsive" style="max-width: 80%; margin: 0 auto;">
<table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <input type="checkbox" hidden class="user-checkbox" data-user-id="{{ $user->id }}">
                    </td>
                    <td>
                        @if (Auth::check() && Auth::user()->id === $user->id)
                            <span class="fa fa-circle text-success">&nbsp;</span>
                        @endif
                        {{ $user->name }}
                    </td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile ?? '' }}</td>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-outline-primary btn-update" data-user-id="{{ $user->id }}" data-toggle="modal" data-target="#updateModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            &nbsp;
                            <button class="btn btn-outline-danger btn-delete" data-user-id="{{ $user->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>



    <!-- <a href="{{ route('user.admin-listing') }}" class=" btn text-light" type="btn" style="background-color: #3A5C77"   >Admin Listing</a> -->
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="update-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="user_name">UserName</label>
                            <input type="text" class="form-control" name="user_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" name="mobile" required>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Active</label>
                            <select class="form-control" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#user-search').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                
                $('.table tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.includes(searchText));
                });
            });
        });
        $(document).ready(function() {
            $('.btn-update').on('click', function() {
                const userId = $(this).data('user-id');
                const userRow = $(this).closest('tr');
                const name = userRow.find('td:eq(1)').text();
                const userName = userRow.find('td:eq(2)').text();
                const email = userRow.find('td:eq(3)').text();
                const mobile = userRow.find('td:eq(4)').text();
                const isActive = userRow.find('td:eq(5)').text().toLowerCase() === 'yes';

                $('#updateModal input[name="id"]').val(userId);
                $('#updateModal input[name="name"]').val(name);
                $('#updateModal input[name="user_name"]').val(userName);
                $('#updateModal input[name="email"]').val(email);
                $('#updateModal input[name="mobile"]').val(mobile);
                $('#updateModal select[name="is_active"]').val(isActive ? '1' : '0');
            });

            $('.update-form').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const userId = $('input[name="id"]').val();
                const url = `/user/${userId}`;

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        const userRow = $(`.btn-update[data-user-id="${userId}"]`).closest('tr');
                        userRow.find('td:eq(1)').text(response.name);
                        userRow.find('td:eq(2)').text(response.user_name);
                        userRow.find('td:eq(3)').text(response.email);
                        userRow.find('td:eq(4)').text(response.mobile);
                        userRow.find('td:eq(5)').text(response.is_active ? 'Yes' : 'No');
                        
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while updating the user.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(error);
                    }
                });
            });

            $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        
        const userId = $(this).data('user-id');
        
        // Show a confirmation dialog using SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                // Send an AJAX request to delete the user
                $.ajax({
                    url: `/user/${userId}`, // Update the URL as per your route
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Remove the deleted row from the table
                        $(`.btn-delete[data-user-id="${userId}"]`).closest('tr').remove();
                        
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while deleting the user.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(error);
                    }
                });
            }
        });
    });
        });
    


        $(document).ready(function() {
            
            $('#promote-admin-btn').hide();

            $('.user-checkbox').on('change', function() {
                const anyCheckboxChecked = $('.user-checkbox:checked').length > 0;
                $('#promote-admin-btn').toggle(anyCheckboxChecked);
            });

            $('#promote-admin-btn').on('click', function() {
                const selectedUserIds = [];

                $('.user-checkbox:checked').each(function() {
                    selectedUserIds.push($(this).data('user-id'));
                });

                if (selectedUserIds.length === 0) {
                    alert('Please select users to promote to admin.');
                    return;
                }

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/promote-admin',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        users: selectedUserIds
                    },
                    success: function(response) {
                    
                        alert(response.message);

                        
                        selectedUserIds.forEach(function(userId) {
                            updateTableRow(userId, response.data[userId]);
                        });
                    },
                    error: function(error) {
                        
                        console.error(error);
                    }
                });
            });

        

            function updateTableRow(userId, userData) {
                const userRow = $(`.user-checkbox[data-user-id="${userId}"]`).closest('tr');
                userRow.find('td:eq(5)').text(userData.is_active ? 'Yes' : 'No');
            }
        });
        $(document).ready(function() {
            $('.btn-update').on('click', function() {
            });

            $('.update-form').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const userId = $('input[name="id"]').val();
                const url = `/user/${userId}`;

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#updateModal').modal('hide');
                        const userRow = $(`.btn-update[data-user-id="${userId}"]`).closest('tr');
                        userRow.find('td:eq(1)').text(response.name);
                        userRow.find('td:eq(2)').text(response.user_name);
                        userRow.find('td:eq(3)').text(response.email);
                        userRow.find('td:eq(4)').text(response.mobile);
                        userRow.find('td:eq(5)').text(response.is_active ? 'Yes' : 'No');

                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = [];

                            for (const field in errors) {
                                errorMessages.push(errors[field][0]);
                            }

                            Swal.fire({
                                title: 'Validation Error',
                                html: errorMessages.join('<br>'),
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while updating the user.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.error(xhr);
                        }
                    }
                });
            });
        });
    </script>

    @endsection
   
    