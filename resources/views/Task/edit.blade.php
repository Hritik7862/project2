@extends('layouts.app')

@section('content')
<div class="container border mt-3">
    <div class="text-center my-5 "><h1 style="font-weight:bolder">Edit Task</h1></div>
   
    <form action="{{ route('task.update', $task->id) }}" method="Post">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="row">
                <!-- item 1 -->
                <div class="col-4">
                    <div class="mb-3">
                        <label for="project_id" class="form-label float-start"><h5>Project Name</h5></label>
                        <select name="project_id" class="form-control bg-light" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" @if($task->project_id === $project->id) selected @endif>{{ $project->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- item 2 -->
                <div class="col-4">
                            <div class="mb-3">
                                <label for="assigned_by" class="form-label float-start">
                                    <h5>Assign By</h5>
                                </label>
                                <select name="assigned_by" class="form-control bg-light" required>
                                    <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                </select>
                            </div>
                        </div>

                <!-- item 3 -->
                <div class="col-4">
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label float-start"><h5>Assign To</h5></label>
                        <select name="assigned_to" class="form-control bg-light" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($task->assigned_to === $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- item 4 -->
                <div class="col-12">
                    <div class="mb-3">
                        <label for="description" class="form-label float-start"><h5>Description</h5></label>
                        <textarea name="description" class="form-control bg-light"  rows="3" required>{{ $task->description }}</textarea>
                    </div>
                </div>

                <!-- item 5 -->
                <div class="col-4">
                    <div class="mb-3">
                        <label for="task_datetime" class="form-label float-start"><h5>Task Date Time</h5></label>
                        <input type="datetime-local" name="task_datetime" class="form-control bg-light" value="{{ date('Y-m-d\TH:i', strtotime($task->task_datetime)) }}" required>
                    </div>
                </div>

                <!-- item 6 -->
                <div class="col-4">
                    <div class="mb-3">
                        <label for="task_name" class="form-label float-start"><h5>Task Name</h5></label>
                        <input type="text" name="task_name" class="form-control bg-light" value="{{ $task->task_name }}" required>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                        <label for="task_status" class="form-label float-start"><h5>Task Status</h5></label>
                        <select name="task_status" class="form-control bg-light" required>
                            <option value="">Select Status</option>
                            <option value="pending" @if($task->task_status === 'pending') selected @endif>Pending</option>
                            <option value="in_progress" @if($task->task_status === 'in_progress') selected @endif>In Progress</option>
                            <option value="Declined" @if($task->task_status === 'Declined') selected @endif>Declined</option>
                        </select>
                    </div>
                </div>

                <div class="form-label float-start">
                    <label for="is_active"><h5>Is Active</h5></label><br>
                    <label for="active">Active</label>
                    <input type="radio" name="is_active" value="1" @if($task->is_active === 1) checked @endif required>
                    <label for="inactive">Inactive</label>
                    <input type="radio" name="is_active" value="0" @if($task->is_active === 0) checked @endif required>
                </div>
            </div>
        </div>

        <!-- submit button -->
        <div class="d-grid mb-3 container">
            <button type="submit" class="btn btn-dark"id="btn-update">Update</button>
        </div>
    </form>
</div>
<script>
        // Handle form submit with SweetAlert confirmation
        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const projectId = form.data('project-id');
            const url = `/project/${projectId}`;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Use SweetAlert to show the confirmation dialog
            Swal.fire({
                title: 'Update Project',
                text: 'Are you sure you want to update this project?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
</script>
@endsection



                                 