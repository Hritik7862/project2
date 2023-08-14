@extends('layouts.app')

@section('project')
    <div class="container border mt-3">
        <div class="text-center my-5">
            <h1 style="font-weight: bolder">Project Management</h1>
        </div>

        <form method="post" action="{{ url('/project') }}" autocomplete="off">
            @csrf
            <div class="container">
                <div class="row">
                    <!-- item 1 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label float-start"><h5>Project Name</h5></label>
                            <input type="text" name="project_name" class="form-control bg-light" style="border: 1px solid #ccc;" id="name" placeholder="Project Name" required>
                        </div>
                    </div>

                    <!-- item 2 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Description</h5></label>
                            <input type="text" name="description" class="form-control bg-light" style="border: 1px solid #ccc;" id="TaskName" placeholder="Description" required>
                        </div>
                    </div>

                    <!-- item 3 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Start Date</h5></label>
                            <input type="date" name="project_start_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_start_date" required>
                        </div>
                    </div>

                    <!-- item 4 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Delivery Date</h5></label>
                            <input type="date" name="project_delivery_data" class="form-control bg-light" style="border: 1px solid #ccc;" id="project_delivery_date" required>
                        </div> 
                    </div>

                    <!-- item 5 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Cost</h5></label>
                            <input type="number" name="project_cost" class="form-control bg-light" style="border: 1px solid #ccc;" id="price" placeholder="Project Cost" required>
                        </div>
                    </div>

                    <!-- item 6 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label float-start"><h5>Project Head</h5></label>
                            <input type="hidden" name="project_head" id="projecthead_id" value="">
                            <input type="text" name="" class="form-control bg-light" style="border: 1px solid #ccc;" id="projecthead" rows="3" readonly hidden>
                            <select id='ph' class="form-control bg-light" style="border: 1px solid #ccc;" onchange="updateProjectHeadName(this)">
                                <option value=''>Select One</option>
                                @foreach($userdata as $key)
                                    <option value="{{$key['id']}}">{{$key['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label float-start"><h5>Project Technologie</h5></label>
                            <input type="text" name="project_technology" class="form-control bg-light" style="border: 1px solid #ccc;" id="based" placeholder="Project Technology" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label float-start"><h5>Project Team Members</h5></label>
                            <input class="form-control" name="project_members" mbsc-input data-dropdown="true" data-tags="true" id="tm" type="hidden" />
                            <input class="form-control"  mbsc-input data-dropdown="true" data-tags="true" id="tm2" type="text" />
                            <select onchange="members()"  id='selectMembers' class="form-control bg-light" style="border: 1px solid #ccc;">
                                <option value="name" mbsc-input id="my-input" data-dropdown="true" data-tags="true">--Select Any--</option>
                                @foreach($userdata as $val)
                                    <option value="<?=$val['id'];?>"><?=$val['name'];?></option>
                                @endforeach
                            </select>
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
                <button name="btn" value="project" class="btn-dark button">Submit <i class="fa fa-solid fa-arrow-right"></i></button>
            </div>
        </form>
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
    </script>
@endsection




