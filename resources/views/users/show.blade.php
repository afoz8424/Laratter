@extends('layouts.app')

@section('content')
	<h1>{{$user->username}}</h1>
	<a href="/{{$user->username}}/follows" class="btn btn-link">
		Following
		<span class="badge badge-default">{{$user->follows->count()}}</span>
	</a>
	<a href="/{{$user->username}}/followers" class="btn btn-link">
		Followers
		<span class="badge badge-default">{{$user->followers->count()}}</span>
	</a>
	@if(Auth::check())
		@if(Gate::allows('dms',$user))
			<form action="/{{$user->username}}/dms" method="post">
				@csrf
				<input type="text" name="message" class="form-control">
				<button type="submit" class="btn btn-success">Send DM</button>
			</form>
		@endif	
		@if(Auth::user()->isFollowing($user))
			<form action="/{{$user->username}}/unfollow" method="post">
				@csrf
				@if(session('success'))
					<span class="text-success">{{session('success')}}</span>
				@endif
				<button class="btn btn-danger">UnFollow</button>
			</form>
		@else
			<form action="/{{$user->username}}/follow" method="post">
				@csrf
				@if(session('success'))
					<span class="text-success">{{session('success')}}</span>
				@endif
				<button class="btn btn-primary">Follow</button>
			</form>
		@endif
		
	@endif	
	<div class="row">
		@foreach($messages as $message)
			<div class="col-6">
				@include('messages.message')
			</div>
		@endforeach
		<div class="mt-2 mx-auto">
            @if(count($messages))
                {{$messages->links()}}
            @endif
        </div>	
	</div>	
@endsection