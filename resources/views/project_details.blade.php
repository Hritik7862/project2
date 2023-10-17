
<div class="container">
    <div id="combined-details-container">
        <table class="table">
            <thead>
                <tr>
                    <!-- <th colspan="5">Project Details</th> -->
                </tr>
                <tr>
                    <th>Project Head</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tr>
                <td>{{ $project->projectHead->name }}</td>
                <td>{{ $project->project_start_data }}</td>
                <td>{{ $project->project_delivery_data }}</td>
                <td>{{ $project->description }}</td>
                <td class="status {{ $project->is_active ? 'active' : 'inactive' }}">
                    {{ $project->is_active ? 'Completed' : 'unCompleted' }}
                </td>
            </tr>
            <thead>
                <tr>
                    <!-- <th colspan="5">Task Details</th> -->
                </tr>
                <tr>
                    <th>Task Name</th>
                    <th>Assigned By</th>
                    <th>Assigned To</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->assignedby->name }}</td>
                    <td>{{ $task->assignedTo->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td class="status {{ $task->is_active ? 'active' : 'inactive' }}">
                        {{ $task->is_active ? 'Completed' : 'unCompleted' }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<style>
    .status.active {
        color: green;
    }

    .status.inactive {
        color: red;
    }
</style>
