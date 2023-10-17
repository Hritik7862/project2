@extends('layouts.app')

@section('content')

<div class="container"    style="width: 40rem;" >

<!-- <img src="\images\bg .png" alt="fsdfd" title=""> -->
    <div class="row justify-content-center row justify-content-center" >
        <div class="col-md-8">
       
            <div class="cardLarger shadow  ">
                <div class="card-header text-white ">{{ __('Project Mangmant Login') }}</div>

                <div class="card-body ">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username"  class="form-label text-white " >{{ __('Username') }}</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror rounded-pill text-white" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus  style="background-color:#D1C1C2;" placeholder="username" >
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror rounded-pill " name="password" required autocomplete="current-password" style="background-color:#D1C1C2;"  placeholder="Password" >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check  text-white  ">
                            <input class="form-check-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        <div class="d-grid gap-2" >
                            <button type="submit" class="btn btn-outline  text-black rounded-pill btn-sm" style="background: rgba(254, 197, 178);">{{ __('Login') }} <i class="fas fa-sign-in-alt"></i></button >
                        </div>

                        
@if (Route::has('password.request'))
    <div class="mt-3 ">
        <a class="btn btn-link "   href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            &nbsp;

    </div> 
@endif
<div class="flex items-center justify-end mt-4 align-middle ">
        <a href="{{ url('auth/google') }}"  class="btn btn-danger fa fa-google">  Sign in <i class="bi bi-google"></i></a>

        </a>
           &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <a href="{{ url('auth/facebook') }}" class="btn btn-primary  fa fa-facebook "> Login with Facebook</a>
    </div> 
          
           </form>
       </div>
   </div>
 </div>
</div>
</div>
@endsection


