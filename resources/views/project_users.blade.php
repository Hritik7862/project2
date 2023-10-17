@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Project Name</h1>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                        </tr>  
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="project-link" data-project-id="{{ $project->id }}" style="color: black;">{{ $project->project_name }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div id="project-details-container">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".project-link").on("click", function () {
            var projectId = $(this).data("project-id");
            $.ajax({
                url: "/project-details/" + projectId,
                method: "GET",
                success: function (data) {
                    $("#project-details-container").html(data);
                }
            });
        });
    });
</script>
@endsection
