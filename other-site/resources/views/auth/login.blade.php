@extends('front-ends.layouts.master')
@section('page_title', 'AJAX DESIGN INC.')

@section('main_content')
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-6">
	            <div class="pc-break-div show-pc hide-mobile"></div>
	            <div class="mobile-break-div hide-pc show-mobile"></div>
	            
	            <div class="card border">
	                <div class="card-header text-center white-text bold-text header1 bg-gradient">Login</div>

	                <div class="card-body">
	                    <div class="text-center">
	                        <img class="m-logo" src="/assets/images/icons/icon.png">
	                    </div>
	                    <br>
	                    <form method="POST" action="{{ route('login') }}">
	                        @csrf

	                        <!-- email -->
	                        <div class="form-group row">
	                            <div class="col-md-10 content-center">
	                                <input id="email" type="email" class="form-control input-form @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">

	                                @error('email')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
	                            </div>
	                        </div>

	                        <!-- password -->
	                        <div class="form-group row">
	                            <div class="col-md-10 content-center">
	                                <input id="password" type="password" class="form-control input-form @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Password">
	                                
	                                @error('password')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <div class="col-md-12 center">
	                                <button type="submit" class="btn btn-grad bold-text">
	                                    {{ __('Login') }}
	                                </button>
	                            </div>
	                            <!-- <div class="col-md-12  center">
	                                @if (Route::has('password.request'))
	                                    <a class="btn btn-link" href="{{ route('password.request') }}">
	                                        {{ __('Forgot Your Password?') }}
	                                    </a>
	                                @endif
	                            </div> -->
	                        </div>

	                        <!-- forgot password -->
	                        <!-- <div class="form-group row">
	                            <div class="col-md-10 offset-md-4 content-center">
	                                <div class="form-check">
	                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

	                                    <label class="form-check-label" for="remember">
	                                        {{ __('Remember Me') }}
	                                    </label>
	                                </div>
	                            </div>
	                        </div> -->
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<br><br><br><br>
@endsection
@section('page_css')
	<link href="{{ asset('assets/css/additional') }}/auth.css" rel="stylesheet">
@endsection