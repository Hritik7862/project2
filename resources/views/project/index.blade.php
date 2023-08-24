@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Project Listing</h1>
    <a href="{{ route('project.create') }}" class="btn btn-dark mb-3">Create New Project</a>

    @if (session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('project.index') }}"; 
        }, 1000); 
    </script>
            @endif
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Project Start Date</th>
                        <th>Project Delivery Date</th>
                        <th>Project Cost</th>
                        <th>Project Head</th>
                        <th>Project Technologie</th>
                        <th>Project Team Members</th>
                        <th>IsActive</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td>{{ $project->description }}</td>
                            <td>{{ $project->project_start_data }}</td>
                            <td>{{ $project->project_delivery_data }}</td>
                            <td>{{ $project->project_cost }}</td>

                            <td>
                                   @if ($project->projectHead)
                                       {{ $project->projectHead->name }}
                                   @else
                                       N/A
                                   @endif
                               </td>
                            <td>{{ $project->project_technology }}</td>
                            <td>
                             @if ($project->projectUser)
                                 @foreach ($project->projectUser as $user)
                                     @if ($user->user)
                                         {{ $user->user->name }}
                                         @if (!$loop->last) 
                                             ,
                                         @endif
                                     @else
                                       
                                     @endif
                                 @endforeach
                             @else
                               
                             @endif
                       </td>

                            <td>{{ $project->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editModal" data-project-id="{{ $project->id }}"><i class="fas fa-edit"></i></button>
                                    <!-- <a href="{{ route('project.edit', $project->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a> -->
    
                                    &nbsp;
                                    <button class="btn btn-danger btn-delete" data-project-id="{{ $project->id }}"><i class="fas fa-trash-alt"></i></button>
                                </div>
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
</div>

<!-- Bootstrap modal for editing project -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editFormContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle the modal and AJAX     -->
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            const projectId = $(this).data('project-id');
            const editUrl = `/project/${projectId}/edit`;

            $.get(editUrl, function(response) {
                $('#editFormContainer').html(response);
            });
        });
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const projectId = $(this).data('project-id');
            const url = `/project/${projectId}`;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            window.location.reload();
                        },
                        error: function(error) {
                            console.error(error);
                            Swal.fire(
                                'Error!',
                                'Delete failed.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection


