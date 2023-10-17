@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Permission</h1>
    <form action="{{ route('permissions.update', ['id' => $permission->id]) }}" method="post">
    @csrf
        @method('put')
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <div class="form-group">
            <label for="guard_name">Guard Name</label>
            <input type="text" name="guard_name" id="guard_name" class="form-control" value="{{ $permission->guard_name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Permission</button>
    </form>
</div>
@endsection
