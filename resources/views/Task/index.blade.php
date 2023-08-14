@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Task Listing</h1>
        <a href="{{ route('task.create') }}" class="btn btn-dark mb-3">Create New Task</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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
                             <td>{{ $task->assignedTo ? $task->assignedTo->name : 'N/A' }}</td>
                            <td>{{ $task->task_datetime }}</td>
                            <td>{{ $task->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-delete" data-task-id="{{ $task->id }}"><i class="fas fa-trash-alt"></i></button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('.btn-delete').on('click', function () {
                const taskId = $(this).data('task-id');
                const url = `/task/${taskId}`;

                Swal.fire({
                    title: 'Confirm Deletion',
                    text: 'Are you sure you want to delete this task?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });

                                // Remove the deleted task row
                                $(`.btn-delete[data-task-id="${taskId}"]`).closest('tr').remove();
                            },
                            error: function (error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while deleting the task.',
                                    icon: 'error',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                                console.error(error);
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
