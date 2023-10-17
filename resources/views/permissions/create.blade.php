@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Permission</h1>
    <form action="{{ route('manpermissions.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter permission name" required>
        </div>
        <div class="form-group">
            <label for="guard_name">Guard Name (default: web)</label>
            <input type="text" name="guard_name" id="guard_name" class="form-control" placeholder="Enter guard name" value="web">
        </div>
        <button type="submit" class="btn btn-primary">Create Permission</button>
    </form>
</div>
@endsection
