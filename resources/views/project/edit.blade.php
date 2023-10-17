<div class="container">
        <div class="card">
            <div class="card-header bg-dark  text-light">
                <h1>Edit Project</h1>
            </div>
            <style>
                .highlighted {
    background-color: #dff0d8; /* Example highlighting color */
    font-weight: bold;
}
            </style>
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
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Start Date</h5></label>
                            <input type="date" name="project_start_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_start_date"value="{{ $project->project_start_data }}" required>
                        </div>
                 
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Delivery Date</h5></label>
                            <input type="date" name="project_delivery_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_delivery_date" value="{{ $project->project_delivery_data }}" required>
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
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label float-start"><h5>Project Team Members</h5></label>
                    <input class="form-control" name="project_members" mbsc-input data-dropdown="true" data-tags="true" id="tm" type="hidden" />
                    <input class="form-control" mbsc-input data-dropdown="true" data-tags="true" id="tm2" type="text" value="{{$info}}"/>
                
                    <select onchange="members()" id='selectMembers' class="form-control bg-light js-example-basic-multiple" name="states[]" multiple="multiple" style="border: 1px solid #ccc; display: none;">
                   <option style="display: none;"></option>
                   @foreach($userdata as $user)
                   <option style="background:<?= (in_array($user->id,$usersId))?'DarkGrey':'' ?>" value="{{ $user->id }}" @if($project->projectUser->contains('id', $user->id)) selected class="highlighted" @endif>
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
        
        function members() {
    var selectedUserId = selectMembers.value;
    var selectedUserName = selectMembers.options[selectMembers.selectedIndex].text;

    if (tm.value.includes(',' + selectedUserId + ',') || tm2.value.includes(selectedUserName)) {
        alert(selectedUserName + ' is already a member of this project.');
    } else {
        tm.value += ',' + selectedUserId + ',';
        tm2.value += ',' + selectedUserName;
        var selectedOption = selectMembers.options[selectMembers.selectedIndex];
        selectedOption.classList.add('highlighted');
    }
}


        
        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const projectId = form.data('project-id');
            const url = `/project/${projectId}`;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

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
        $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

function updateProjectHeadName(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var projectHeadName = selectedOption.text;
            var projectHeadId = selectedOption.value;
            document.getElementById('projecthead').value = projectHeadName;
            document.getElementById('projecthead_id').value = projectHeadId;
        }
        $(document).ready(function () {
        const currentDate = new Date().toISOString().split('T')[0];

        $('#project_start_date').attr('min', currentDate);

        $('#project_delivery_date').attr('min', currentDate);
    });
          
    
    $(document).ready(function() {
        $('#tm2').click(function() {
           
            $('#selectMembers').toggle();
        });
    });
    </script>
