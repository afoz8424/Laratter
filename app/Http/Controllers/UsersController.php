<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrivateMessage;
use App\Conversation;
use App\User;
use App\Notifications\UserFollowed;

class UsersController extends Controller
{
    public function show($username)
    {
    	$user = $this->findByUsername($username);
    	$messages = $user->messages()->paginate(10); 
    	
    	return view('users.show',[
    		'user' => $user,
    		'messages' => $messages
    	]);
    }

    public function follow($username, Request $request)
    {
        $user = $this->findByUsername($username);

        $me = $request->user();
        $me->follows()->attach($user);
        $user->notify(new UserFollowed($me));

        return redirect("/$username")->withSuccess('Followed');
    }

    public function unfollow($username, Request $request)
    {
        $user = $this->findByUsername($username);

        $me = $request->user();
        $me->follows()->detach($user);

        return redirect("/$username")->withSuccess('UnFollowed');
    }

    public function follows($username)
    {
        $user = $this->findByUsername($username);
        
        return view('users.follows',[
            'user' => $user,
            'follows' => $user->follows,
        ]);
    }

    public function followers($username)
    {
        $user = $this->findByUsername($username);
        
        return view('users.follows',[
            'user' => $user,
            'follows' => $user->followers,
        ]);
    }

    public function sendPrivateMessage($username, Request $request)
    {
        $user = $this->findByUsername($username);

        $me = $request->user();
        $message = $request->input('message');

        $conversation = Conversation::between($me,$user);

        $PrivateMessage = PrivateMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $me->id,
            'message' => $message,
        ]);

        return redirect('/conversations/'.$conversation->id);
    }

    public function showConversation(Conversation $conversation)
    {
        $conversation->load('users','privateMessages');

        //validando si el usuario en sesión es parte de la conversación
        $me=auth()->user(); 
        $validator=false;
        foreach($conversation->users as $user){
            if(($user->username)==$me->username){
              $validator=true;
            }
        }
        if($validator==false){
            return redirect('/');
        }
        
        return view('users.conversation',[
            'conversation' => $conversation,
            'user' => auth()->user(),
        ]);
    }

    private function findByUsername($username)
    {
        return User::where('username',$username)->firstOrFail();
    }

    public function notifications(Request $request)
    {
        return $request->user()->unreadNotifications;
    }

    public function deleteNotifications(Request $request,$id,$username)
    {
        $request->user()->unreadNotifications
            ->where('id',$id)
            ->markAsRead();
        return redirect("/$username");
    }

}
