@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.form')
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Form / Persional / View</h3>
    <br>
	<div class="signup-form">
		<form id="update" action="{{ route('form/update') }}" method = "post">
            {{ csrf_field() }}
			<div class="row">
				<div class="col-8 offset-4">
					<h2>Personal</h2>
				</div>
			</div>	
            <input type="hidden" class="form-control" id="e_id" name="id" value="{{ $data[0]->id }}"/>
			<div class="form-group row">
				<label class="col-form-label col-4">Full Name</label>
				<div class="col-8">
					<input type="text" class="form-control" name="name" value="{{ $data[0]->username }}">
				</div>        	
			</div>
			<div class="form-group row">
				<label class="col-form-label col-4">Email Address</label>
				<div class="col-8">
					<input type="email" class="form-control" name="email" value="{{ $data[0]->email }}">
				</div>	
			</div>
			<div class="form-group row">
				<label class="col-form-label col-4">Phone Number</label>
				<div class="col-8">
					<input type="tel" class="form-control" name="phone" value="{{ $data[0]->phone }}">
				</div>      	
			</div>
			<div class="form-group row">
				<div class="col-8 offset-4">
					<button type="submit" class="btn btn-primary btn-lg">Update</button>
				</div>  
			</div>		      
		</form>
	</div>
</main>		

@endsection