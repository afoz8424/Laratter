<?php

namespace App\Http\Controllers;

use App\Message;
use App\Http\Requests\CreateMessageRequest;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function show(Message $message)
    {
    	/*$message = Message::find($id);*/
    	return view('messages.show',[
    		'message'=>$message,
    	]);
    }
    public function create(CreateMessageRequest $request)
    {
    	$user = $request->user();
        $image = $request->file('image');
        $message = Message::create([
    		'content'=>$request->input('message'),
    		'image' => $image->store('messages','public'),
            'user_id' => $user->id
    	]);

    	return redirect('/messages/'.$message->id);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Busqueda en base de datos
        /*$messages = Message::with('user')
            ->where('content','lIKE',"%$query%")
            ->paginate(10);*/
        
        // Busqueda con laravel scout
        $messages = Message::search($query)
            ->paginate(10);
        $messages->load('user');        

        return view('messages.index',[
            'messages' => $messages,
        ]);
    }

    public function responses(Message $message)
    {
        return $message->responses;
    }
}
