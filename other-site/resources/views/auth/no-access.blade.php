@extends('front-ends.layouts.master')
@section('page_title', 'AJAX DESIGN INC.')

@section('main_content')
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12 text-center" style="margin-top: 150px;margin-bottom: 50px;">
	        	<h2 style="color: red">Sorry, but you don't have rights to access this page.</h2>
	        </div>
	    </div>
	</div>
	<br><br><br><br>
@endsection
@section('page_css')
	<link href="{{ asset('assets/css/additional') }}/auth.css" rel="stylesheet">
@endsection