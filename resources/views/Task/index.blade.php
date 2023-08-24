@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Task Listing</h1>
        <a href="{{ route('task.create') }}" class="btn btn-dark mb-3">Create New Task</a>
        @if (session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('task.index') }}";
        }, 1000); 
    </script>

        @endif
        <div class="table-responsive">
            <table id="tasks-table" class="table table-striped">
                <thead>
                <tr>
                        <th>S.No</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Project Name</th>
                        <th>Assign By</th>
                        <th>Assign To</th>
                        <th>Task Date Time</th>
                        <th>Is Active</th>
                        <th>Actions</th>
                    </tr>
                   </thead>
                <tbody>
                @php
                        $count = 1;
                    @endphp
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->project->project_name }}</td>
                            <td>{{ $task->assignedBy ? $task->assignedBy->name : 'N/A' }}</td>
                            <td>{{ $task->assignedTo ? $task->assignedTo->name : '' }}</td>
                            <td>{{ $task->task_datetime }}</td>
                            <td>{{ $task->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                            <div class="d-flex">
                            <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary" id="openEditPopup"><i class="fas fa-edit"></i></a>
                                <!-- <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editTaskModal" data-task-id="{{ $task->id }}"><i class="fas fa-edit"></i></button> -->
                                &nbsp;
                                <button class="btn btn-danger btn-delete" data-task-id="{{ $task->id }}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
     $(document).ready(function () {
            // Edit Task Modal
            $('.btn-edit').on('click', function () {
                const taskId = $(this).data('task-id');
                const modal = $('#editTaskModal');

                // Fetch task data using AJAX and populate the modal fields
                $.ajax({
                    url: `/task/${taskId}/edit`,
                    type: 'GET',
                    success: function (response) {
                        modal.find('.modal-body').html(response);
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });

            // Update Task
            $('#updateTaskBtn').on('click', function () {
                const modal = $('#editTaskModal');
                const taskId = modal.find('.btn-edit').data('task-id');
                const formData = modal.find('form').serialize();

                $.ajax({
                    url: `/task/${taskId}`,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        modal.modal('hide');
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });
           
            $('.btn-delete').on('click', function () {
                const taskId = $(this).data('task-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/task/${taskId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                             
                                $(`.btn-delete[data-task-id="${taskId}"]`).closest('tr').remove();
                                
                                Swal.fire(
                                    'Deleted!',
                                    'The task has been deleted.',
                                    'success'
                                );
                            },
                            error: function (error) {
                                console.error(error);
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection







