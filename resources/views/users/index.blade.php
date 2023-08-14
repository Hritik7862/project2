@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Listing</h1>
    <a href="{{ route('register') }}" class="btn btn-dark mb-3">New User Create</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- <form id="user-list-form"> -->
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
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
                            <input type="checkbox" class="user-checkbox" data-user-id="{{ $user->id }}">
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile ?? 'N/A' }}</td>
                        <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <button class="btn btn-primary btn-update" data-user-id="{{ $user->id }}" data-toggle="modal"
                                data-target="#updateModal"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-delete" data-user-id="{{ $user->id }}"><i
                                    class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-success" id="promote-admin-btn">Users to Admin</button>
    <!-- </form> -->
    <a href="{{ route('user.admin-listing') }}" class="btn btn-primary">Admin Listing</a>

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
                        <input type="text" class="form-control" name="name" required >
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update User AJAX
    $('.update-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const userId = form.find('input[name="id"]').val();
        const url = `/user/${userId}`;

        // Get the CSRF token value
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'get',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                alert(response.message);
                const row = form.closest('tr');
                row.find('td:eq(0)').text(form.find('input[name="name"]').val());
                row.find('td:eq(1)').text(form.find('input[name="user_name"]').val());
                row.find('td:eq(2)').text(form.find('input[name="email"]').val());
                row.find('td:eq(3)').text(form.find('input[name="mobile"]').val() || 'N/A');
                row.find('td:eq(4)').text(form.find('select[name="is_active"] option:selected').text());
                $('#updateModal').modal('hide');
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    $('.btn-update').on('click', function(e) {
        const userId = $(this).data('user-id');
        const userRow = $(this).closest('tr');
        const name = userRow.find('td:eq(0)').text();
        const user_name = userRow.find('td:eq(1)').text();
        const email = userRow.find('td:eq(2)').text();
        const mobile = userRow.find('td:eq(3)').text();
        const isActive = userRow.find('td:eq(4)').text() === 'Yes' ? 1 : 0;

        const updateModal = $('#updateModal');
        updateModal.find('input[name="id"]').val(userId);
        updateModal.find('input[name="name"]').val(name);
        updateModal.find('input[name="user_name"]').val(user_name);
        updateModal.find('input[name="email"]').val(email);
        updateModal.find('input[name="mobile"]').val(mobile === 'N/A' ? '' : mobile);
        updateModal.find('select[name="is_active"]').val(isActive);

        updateModal.modal('show');
    });

    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const url = `/user/${userId}`;

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Confirm Delete',
            text: 'Are you sure you want to delete this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Use SweetAlert for success message
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            const userRow = $(`.btn-delete[data-user-id="${userId}"]`).closest('tr');
                            userRow.remove();
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

    // Promote selected users to admin
    $('#promote-admin-btn').on('click', function(e) {
        e.preventDefault();

        const selectedUsers = [];
        $('.user-checkbox:checked').each(function() {
            selectedUsers.push($(this).data('user-id'));
        });

        if (selectedUsers.length === 0) {
            alert('Please select at least one user to promote.');
            return;
        }

        const url = '/promote-admin';

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                users: selectedUsers
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
</script>
@endsection
