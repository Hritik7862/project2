@extends('layouts.app')

@section('project')

<div class="container mt-3">
    <div class="card shadow-lg p-3 mb-5 bg-body rounded">
        <div class="card-body">
            <h1 class="card-title text-center font-weight-bold mb-4">Project Management</h1>

            <form method="post" action="{{ url('/project') }}" autocomplete="off">
                @csrf
                <div class="row">
                    <!-- Project Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><h5>Project Name</h5></label>
                        <input type="text" name="project_name" class="form-control" placeholder="Project Name" required >
                    </div>

                    <!-- Description -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><h5>Description</h5></label>
                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                    <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Start Date</h5></label>
                     <input type="date" name="project_start_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_start_date" required>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Delivery Date</h5></label>
                    <input type="date" name="project_delivery_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_delivery_date"  required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><h5>Project Cost</h5></label>
                        <input type="number" name="project_cost" class="form-control" placeholder="Project Cost" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><h5>Project Head</h5></label>
                        <select id='ph' class="form-control" onchange="updateProjectHeadName(this)" required>
                            <option value=''>Select One</option>
                            @foreach($userdata as $key)
                                <option value="{{$key['id']}}">{{$key['name']}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="project_head" id="projecthead_id" value="">
                        <input type="text" name="project_head_name" class="form-control mt-2" id="projecthead" readonly hidden>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><h5>Project Technology</h5></label>
                        <input type="text" name="project_technology" class="form-control" placeholder="Project Technology" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><h5>Project Team Members</h5></label>
                        <select id="selectMembers" class="js-example-basic-multiple form-control" multiple>
                            @foreach($userdata as $val)
                                <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="project_members" id="tm" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><h5>Is Active</h5></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="1" required>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" value="0" required>
                            <label class="form-check-label">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-3">
                        <button name="btn" value="project" class="btn btn-dark btn-sm rounded-pill">Submit <i class="fa fa-solid fa-arrow-right"></i></button>
                    </div>
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
  
    
    $(document).ready(function () {
        const currentDate = new Date().toISOString().split('T')[0];

        $('#project_start_date').attr('min', currentDate);
        $('#project_delivery_date').attr('min', currentDate);

        $('.js-example-basic-multiple').select2(); 


        $('#selectMembers').on('change', function () {
            const selectedMembers = $(this).val();
            $('#tm').val(selectedMembers);
        });
    });
    
</script>
@endsection





