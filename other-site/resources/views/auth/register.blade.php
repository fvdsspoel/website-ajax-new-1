@extends('layouts.app',['title' => 'REGISTER'])
@section('styles')
    <link href="{{ asset('assets/css') }}/auth.css" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="pc-break-div show-pc hide-mobile"></div>
            <div class="mobile-break-div hide-pc show-mobile"></div>

            <div class="card">
                <div class="card-header text-center white-text bold-text header1 bg-gradient">Register</div>

                <div class="card-body">
                    <div class="text-center">
                        <img class="m-logo" src="/assets/images/icons/icon.png">
                    </div>
                    <br>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-10 content-center">
                                <input id="first_name" type="text" class="form-control input-form @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="Enter  First Name">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 content-center">
                                <input id="last_name" type="text" class="form-control input-form @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Enter Last Name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-10 content-center">
                                <input id="email" type="email" class="form-control input-form @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 content-center">
                                <input id="password" type="password" class="form-control input-form @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-10 content-center">
                                <input id="password-confirm" type="password" class="form-control input-form" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 center">
                                <button type="submit" class="btn btn-grad bold-text">
                                    Register
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
