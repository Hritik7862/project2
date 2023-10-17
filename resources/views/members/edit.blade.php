
<form method="POST" action="{{ route('members.update', $member->id) }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}">
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="number" class="form-control" id="age" name="age" value="{{ $member->age }}">
    </div>

    <div class="form-group">
        <label for="date_of_birth">Date of Birth</label>
        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $member->date_of_birth }}">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
