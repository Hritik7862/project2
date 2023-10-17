@extends('layouts.app')

@section('content')
    <div class="container ">
        <h1>Task Listing</h1>
        @can('create tasks', 'superadmin')
            <a href="{{ route('task.create') }}" class="btn btn-outlinek mb-3" style="background-color: #BABABB;">Create New Task</a>
        @endcan
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} 
            </div>
            <script>
                setTimeout(function () {
                    window.location.href = "{{ route('task.index') }}";
                }, 1000); 
            </script>
        @endif
        <div class="table-responsive">
            <table id="tasks-table" class="table table-striped">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Project Name</th>
                    <th hidden>Assign By</th>
                    <th>Assign To</th>
                    <th>Task Date Time</th>
                    <th>Is Active</th>
                    <th>Task Completed</th>
                    <th></th>
                    @can('edit tasks', 'delete tasks')
                        <th>Actions</th>
                    @endcan

                </tr>
                </thead>
                <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->project->project_name }}</td>
                        <td hidden>{{ $task->assignedBy ? $task->assignedBy->name : 'N/A' }}</td>
                        <td>{{ $task->assignedTo ? $task->assignedTo->name : '' }}</td>
                        <td>{{ $task->task_datetime }}</td>
                        <td>{{ $task->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                          @if ($task->is_completed)
                              Completed
                          @else
                              @if ($task->notifications->count() > 0)
                                  Completed
                              @else
                                  Uncompleted
                              @endif
                          @endif
                      </td>

                      <td>
  @if (Auth::user()->hasRole('user'))
    <div class="d-flex">
      <form method="post" action="{{ route('saveTaskCompletion', $task->id) }}">
        @csrf
        <input type="checkbox" class="task-complete-checkbox" data-task-id="{{ $task->id }}" name="is_completed" value="1" style="{{ $task->notifications->where('is_completed', 1)->count() > 0 ? 'display: none;' : '' }}" onchange="myfun({{ $task->id }})">
        <input type="text" id="remarks-input-{{ $task->id }}" name="remark" style="display: none;" placeholder="Add a remark">
        <button type="submit" id="complete-button-{{ $task->id }}" class="btn btn-primary" style="display: none;">Completed</button>
        <input type="hidden" name="task_id" value="{{ $task->id }}">
      </form>
    </div>
  @endif
</td>

                       
                       
                        <td>
                            @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                <div class="d-flex">
                                    @can('edit tasks')
                                        <a href="{{ route('task.edit', $task->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    &nbsp;
                                    @can('delete tasks')
                                        <button class="btn btn-outline-danger btn-delete" data-task-id="{{ $task->id }}"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                </div>
                            @endif
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

    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>




    <script>
     $(document).ready(function () {
            // Edit Task Modal
            $('.btn-edit').on('click', function () {
                const taskId = $(this).data('task-id');
                const modal = $('#editTaskModal');

                $.ajax({
                    url: `/task/${taskId}/edit`,
                    type: 'GET',
                    success: function (response) {
                        modal.find('.modal-body').html(response);
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });

            // Update Task
            $('#updateTaskBtn').on('click', function () {
                const modal = $('#editTaskModal');
                const taskId = modal.find('.btn-edit').data('task-id');
                const formData = modal.find('form').serialize();

                $.ajax({
                    url: `/task/${taskId}`,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        modal.modal('hide');
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });
           
            $('.btn-delete').on('click', function () {
                const taskId = $(this).data('task-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/task/${taskId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                             
                                $(`.btn-delete[data-task-id="${taskId}"]`).closest('tr').remove();
                                
                                Swal.fire(
                                    'Deleted!',
                                    'The task has been deleted.',
                                    'success'
                                );
                            },
                            error: function (error) {
                                console.error(error);
                            },
                        });
                    }
                });
            });
        });
        $('.task-complete-checkbox').on('change', function () {
        const taskId = $(this).data('task-id');
        const remarksInput = $(`#remarks-input-${taskId}`);
        const completeButton = $(`#complete-button-${taskId}`);

        if ($(this).is(':checked')) {
            remarksInput.show(); 
            completeButton.show();
        } else {
            remarksInput.hide();
            completeButton.hide();
        }
    });
function myfun() {
  alert("Are you sure you want to mark this task as completed?");
}
      

    </script>
@endsection








