
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark  text-light">
                <h1>Edit Project</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('project-update', $project->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $project->project_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="project_start_data">Project Start Date</label>
                        <input type="date" class="form-control" id="project_start_data" name="project_start_data" value="{{ $project->project_start_data }}" required>
                    </div>
                    <div class="form-group">
                        <label for="project_delivery_data">Project Delivery Date</label>
                        <input type="date" class="form-control" id="project_delivery_data" name="project_delivery_data" value="{{ $project->project_delivery_data }}" required>
                    </div>
                    <div class="form-group">
                        <label for="project_cost">Project Cost</label>
                        <input type="number" class="form-control" id="project_cost" name="project_cost" value="{{ $project->project_cost }}" required>
                    </div>
                    <div class="form-group">
                        <label for="project_head">Project Head</label>
                        <select class="form-control" id="project_head" name="project_head" required>
                            @foreach($userdata as $user)
                                <option value="{{ $user->id }}" @if($user->id === $project->project_head) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="project_technology">Project Technology</label>
                        <input type="text" class="form-control" id="project_technology"name="project_technology" value="{{ $project->project_technology }}" required>
                    </div>
                 
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label float-start"><h5>Project Team Members</h5></label>
                        <input class="form-control" name="project_members"  mbsc-input data-dropdown="true" data-tags="true" id="tm" type="hidden" />
                        <input class="form-control"  mbsc-input data-dropdown="true" data-tags="true" id="tm2" type="text" />
                            <select onchange="members()"  id='selectMembers' class="form-control bg-light" style="border: 1px solid #ccc;">
                            <option value="name" mbsc-input id="my-input" data-dropdown="true" data-tags="true">--Select Any--</option>
                            @foreach($userdata as $user)
                            <option value="{{ $user->id }}" @if(in_array($user->id, collect($project->projectMembers)->pluck('id')->toArray())) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                          
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Is Active</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="active_yes" value="1" @if($project->is_active) checked @endif required>
                            <label class="form-check-label" for="active_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_active" id="active_no" value="0" @if(!$project->is_active) checked @endif required>
                            <label class="form-check-label" for="active_no">No</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark" id="btn-update">Update Project</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        
        function members(event){
    // console.log(window.event.target.options );
    tm.value+=selectMembers.value+',';
    tm2.value+=selectMembers.options[selectMembers.selectedIndex].text+',';
}

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
