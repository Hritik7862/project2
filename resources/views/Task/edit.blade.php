@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card border shadow">
        <div class="card-body">
            <div class="text-center my-5"><h1 style="font-weight: bolder">Edit Task</h1></div>

            <form action="{{ route('task.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="container">
                    <div class="row">
                        <!-- Project Name -->
                        <div class="col-md-4">
                            <div class="mb-3">
                            <label for="project_id" class="form-label float-start"><h5>Project Name</h5></label>
                                <select name="project_id" class="form-control bg-light" onchange="subjects(this)" id='project_name'>
                                    <option value="" hidden>Select Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}" <?= ($project->project_name == $task->project->project_name)?'selected':'' ?>>{{ $project->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                        <input type="hidden" name="assigned_by" value="{{ auth()->user()->id }}">
                        </div>
                        </div>
                        <!-- Assign To -->
                        <div class="col-md-4">
                            <div class="mb-3">
                            <label for="assigned_to" class="form-label float-start" ><h5>Assign To</h5></label>
                                <select name="assigned_to" class="form-control bg-light" required  id="assignedToSelect" >
                                    <option value="" hidden>Select User</option>
                                    @foreach($users as $user)
                                        @if($user->id !== auth()->user()->id)
                                            <option value="{{ $user->id }}" <?= ($task->assignedTo->name == $user->name)?'selected':''  ?>>{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label float-start"><h5>Description</h5></label>
                                <textarea name="description" class="form-control bg-light" rows="3" required>{{ $task->description }}</textarea>
                            </div>
                        </div>

                        <!-- Task Date Time -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="task_datetime" class="form-label float-start"><h5>Task Date Time</h5></label>
                                <input type="datetime-local" id="task_datetime" name="task_datetime" class="form-control bg-light" value="{{ date('Y-m-d\TH:i', strtotime($task->task_datetime)) }}" required>
                            </div>
                        </div>

                        <!-- Task Name -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="task_name" class="form-label float-start"><h5>Task Name</h5></label>
                                <input type="text" name="task_name" class="form-control bg-light" value="{{ $task->task_name }}" required>
                            </div>
                        </div>

                        <!-- Is Active Radio Buttons -->
                        <div class="col-md-4">
                            <label class="form-label"><h5>Is Active</h5></label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" value="1" @if($task->is_active === 1) checked @endif required>
                                <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" value="0" @if($task->is_active === 0) checked @endif required>
                                <label class="form-check-label">Inactive</label>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-lg" id="btn-update">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function subjects(project_name) {
    var selectedOption = project_name.options[project_name.selectedIndex];
    var projectId = selectedOption.value;
    console.log(projectId);

    $.ajax({
        url: '/projects/getName', 
        data: { name: projectId },
        type: 'get',
        success: function(data) {
            console.log(data);
            var assignToSelect = document.getElementById('assignedToSelect');
            assignToSelect.innerHTML = '<option value="">Select User</option>';
             
            data.users.forEach(function(user) {
                var option = document.createElement('option');
                option.value = user.id;
                option.text = user.name;
                assignToSelect.appendChild(option);
            });
        },
        error: function(xhr, status, error) {
            console.log(error); 
        }
    });
}
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
        document.addEventListener('DOMContentLoaded', function() {
        const taskDateTimeInput = document.getElementById('task_datetime');
        const now = new Date().toISOString().slice(0, 16); 

        taskDateTimeInput.min = now;
    });
       
</script>
@endsection