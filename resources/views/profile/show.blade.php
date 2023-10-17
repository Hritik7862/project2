<!-- resources/views/profile/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        @if (Session::has('success'))
    <div id="successMessage" class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

            <!-- User Profile -->
            <div class="card">
                <div class="card-header fw-bolder  text-info m-0" >{{ __('My Profile') }}</div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="profile-picture-small mb-3">
                           <br>
                        <h4>{{ $user->name }}</h4>  
                        <h6>(Web Developer)</h6>
                     
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Add a button/link to show details -->
                            <button id="showDetails" class="btn btn text-white " style="background-color:rgb(0, 0, 139);">Details</button>
                        </div>
                        <!-- Other user information here -->
                    </div>
                    <!-- Additional details hidden by default -->
                    <div id="userDetails" style="display: none;">
                       <h4>Name</h4>
                       <p>{{ $user->name }}</p>
                       <h4>Username</h4>
                       <p>{{ $user->user_name }}</p>
                       <h4>Email</h4>
                       <p>{{ $user->email }}</p>
                       <h4>Mobile no.</h4>
                       <p>{{ $user->mobile }}</p>
                       <h4>Admin</h4>
                       <p>{{ $user->admin == 1 ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-header fw-bolder  text-info m-0" >{{ __('Account Settings') }}</div>
                <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
     
                        <!-- Profile Picture -->
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                        </div>
                             
                        <!-- User Name -->
                        <div class="form-group">
                            <label for="user_name">Username</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->user_name }}">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>

                        <!-- Mobile -->
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}">
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn bt text-white" style="background-color:rgb(0, 0, 139);">Update Profile</button>
                    </form>
                </div>
            </div>
    <!-- Change Password Card -->
<div class="card mt-3">
    <div class="card-header fw-bolder  text-info m-0">{{ __('Setup New Password') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.change-password') }}">
            @csrf
            @method('POST')
            <!-- New Password -->
            <div class="form-group">
                <label for="new_password">{{ __('New Password') }}</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>

            <!-- Submit button for changing password -->
            <button type="submit" class="btn bt text-white" style="background-color:rgb(0, 0, 139);">{{ __('Change Password') }}</button>
        </form>
    </div>
</div>
       
        </div>
    </div>
</div>

<!-- JavaScript to toggle details -->
<script>
    document.getElementById("showDetails").addEventListener("click", function() {
        var userDetails = document.getElementById("userDetails");
        userDetails.style.display = userDetails.style.display === "none" ? "block" : "none";
    });

    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = document.getElementById("successMessage");

        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = "none";
            }, 2000);
        }
    });
</script>
@endsection
