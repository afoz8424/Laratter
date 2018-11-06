@extends('layouts.app')

@section('content')
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