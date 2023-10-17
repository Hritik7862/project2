@extends('layouts.app')

@section('content')
<div class="container mt-3"  style="width: 45rem;">
    <div class="card shadow-lg p-3 mb-5 bg-body rounded ">
        <div class="card-body">
            <div class="text-center my-5 ">
                <h1 style="font-weight: bold;">Task Management</h1>
            </div>

            <form method="post" action="/task" autocomplete="off">
                @csrf
                <div class="container" style="background: rgba(255, 99, 71, 0);">
                    <div class="row ">
                        <!-- item 1 -->
                        <div class="col-md-4 ">
                            <div class="mb-3">
                                <label for="project_id" class="form-label float-start"><h5>Project Name</h5></label>
                                <select name="project_id" class="form-control bg-light" onchange="subjects(this)" id='project_name'>
                                    <option value="" hidden>Select Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- item 2 -->
                        <div class="col-md-4">
                            <input type="hidden" name="assigned_by" value="{{ auth()->user()->id }}">
                        </div>

                        <!-- item 3 -->
                        <div class="col-md-4">
                            <div class="mb-3">
                            <label for="assigned_to" class="form-label float-start" ><h5>Assign To</h5></label>
                                <select name="assigned_to" class="form-control bg-light" required  id="assignedToSelect" >
                                    <option value="" hidden>Select User</option>
                                    @foreach($users as $user)
                                        @if($user->id !== auth()->user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- item 4 -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label"><h5>Description</h5></label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>

                        <!-- item 5 -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="task_datetime" class="form-label"><h5>Task Date Time</h5></label>
                                <input type="datetime-local" id="task_datetime" name="task_datetime" class="form-control" required>
                            </div>
                        </div>

                        <!-- item 6 -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="task_name" class="form-label"><h5>Task Name</h5></label>
                                <input type="text" name="task_name" class="form-control" required>
                            </div>
                        </div>

                        <!-- Radio buttons -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h5 class="form-label">Is Active</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" value="1" id="active" required>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" value="0" id="inactive" required>
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- submit button -->
                    <div class="d-grid gap-2 mb-3">
                        <button name="btn" value="project" class=" btn btn-outline-dark btn-sm rounded-pill">Submit <i class="fa fa-solid fa-arrow-right"></i></button>
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
    // console.log(projectId);

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

    document.addEventListener('DOMContentLoaded', function() {
        const taskDateTimeInput = document.getElementById('task_datetime');
        const now = new Date().toISOString().slice(0, 16); 

        taskDateTimeInput.min = now;
    });
           
</script>
@endsection