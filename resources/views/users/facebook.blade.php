@extends('layouts.app')

@section('content')
	<form action="/auth/facebook/register" method="post">
		@csrf
		<div class="card">
			<div class="card-bloc">
				<img src="{{$user->avatar}}" class="img-thumbnail">
			</div>
			<div class="card-bloc">
				<div class="form-group">
					<label for="name" class="form-control-label">Name</label>
					<input class="form-control" type="text" name="name" value="{{$user->name}}" readonly>
				</div>
				<div class="form-group">
					<label for="email" class="form-control-label">Email</label>
					<input class="form-control" type="text" name="email" value="{{$user->email}}" readonly>
				</div>
				<div class="form-group">
					<label for="name" class="form-control-label">Username</label>
					<input class="form-control" type="text" name="username" value="{{old('username')}}">
				</div>
			</div>
			<div class="card-footer">
				<button class="btn btn-primary" type="submit">Register</button>
			</div>
		</div>
	</form>
@endsection