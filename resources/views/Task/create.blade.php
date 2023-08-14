@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card ">
        <div class="card-body">
            <div class="text-center my-5 "><h1 style="font-weight:bolder">Task Management</h1></div>

            <form method="post" action="/task" autocomplete="off">
                @csrf
                <div class="container">
                    <div class="row">
                        <!-- item 1 -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="project_id" class="form-label float-start"><h5>Project Name</h5></label>
                                <select name="project_id" class="form-control bg-light" >
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- item 2 -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="assigned_by" class="form-label float-start" hidden>
                                    <!-- <h5>Assign By</h5> -->
                                </label>
                                <select name="assigned_by" class="form-control bg-light" required hidden >
                                    <option value="{{ auth()->user()->id }}" hidden>{{ auth()->user()->name }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- item 3 -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="assigned_to" class="form-label float-start" ><h5>Assign To</h5></label>
                                <select name="assigned_to" class="form-control bg-light" required  id="assignedToSelect" >
                                    <option value="">Select User</option>
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
                                <label for="description" class="form-label float-start"><h5>Description</h5></label>
                                <textarea name="description" class="form-control bg-light" style="border:0" rows="3" required></textarea>
                            </div>
                        </div>

                        <!-- item 5 -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="task_datetime" class="form-label float-start"><h5>Task Date Time</h5></label>
                                <input type="datetime-local" id="task_datetime" name="task_datetime" class="form-control bg-light" required>
                            </div>
                        </div>

                        <!-- item 6 -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="task_name" class="form-label float-start"><h5>Task Name</h5></label>
                                <input type="text" name="task_name" class="form-control bg-light" required>
                            </div>
                        </div>

                    

                        <div class="form-label float-start">
                            <label for="is_active"><h5>Is Active</h5></label><br>
                            <label for="active">Active</label>
                            <input type="radio" name="is_active" value="1" required>
                            <label for="inactive">Inactive</label>
                            <input type="radio" name="is_active" value="0" required>
                        </div>
                    </div>
                </div>

                <!-- submit button -->
                <div class="d-grid mb-3 container">
                    <button type="submit" class="btn btn-dark">Submit <i class="fa fa-solid fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskDateTimeInput = document.getElementById('task_datetime');
        const now = new Date().toISOString().slice(0, 16); 

        taskDateTimeInput.min = now;
    });
           
</script>
@endsection






<!-- 
<select id="assignedToSelect" name="assigned_to" class="form-control bg-light" required>
    <option value="">Select User</option> -->