@extends('layouts.app')

@section('content')
    
<div class="container py-5"style="width: 50rem;" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card Larger shadow" >
                <div class="card-header  text-white" style="background-color: #8EB4C7;">{{ __('Users Signup To Website') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label">{{ __('Name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label">{{ __('User Name') }}</label>
                            <div class="col-md-8">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus placeholder="UserName">
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label">{{ __('Mobile') }}</label>
                            <div class="col-md-8">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus placeholder="Mobile">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                           
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>
                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label">{{ __('Role') }}</label>
                            <div class="col-md-8">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                         <input type="hidden" name="admin" value="0">
                         </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{ __('Is Active') }}</label>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_active" value="1" {{ old('is_active') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_inactive" value="0" {{ old('is_active') == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_inactive">Inactive</label>
                                </div>
                                @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             </div>
                           <div class="form-group row">
                           <label for="profile_picture" class="col-md-4 col-form-label">{{ __('Profile Picture') }}</label>
                           <div class="col-md-8">
                               <input id="profile_picture" type="file" class="form-control-file @error('profile_picture') is-invalid @enderror" name="profile_picture" accept="image/*">
                               @error('profile_picture')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                           </div>
                       </div>
                       
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline" style="background-color: #9dbcd0;">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
