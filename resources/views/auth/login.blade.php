@extends('layouts.auth.main')
@section('main_content')
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in</p>

      <form action="{{ route('login') }}" method="post">
        @csrf  
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-circle"></span>
            </div>
          </div>
          @error('username')
            <span class="invalid-feedback" rol="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
            <span class="invalid-feedback" rol="alert">
              <strong>{{ $message }}</strong>
            </span>  
          @enderror
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- <p class="mb-1">
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
        @endif
      </p> -->
      <!-- <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
@endsection

