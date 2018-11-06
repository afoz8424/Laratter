<?php

namespace App\Http\Controllers;

use App\User;
use App\SocialProfile;
use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller
{
    public function facebook()
    {
    	return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
    	$user = Socialite::driver('facebook')->user();
    	//$data = $request->session()->get('facebookUser');

        $existing = User::whereIn('users.id', function($query) use($user) {
                    $query->from('social_profiles')
                            ->select('social_profiles.user_id')
                            ->where('social_profiles.social_id', $user->id);
                })->first();
        if($existing !== null)
        {
            auth()->login($existing);
            return redirect('/');
        }
    	session()->flash('facebookUser',$user);
    	return view('users.facebook',[
    		'user' => $user,
    	]);
    }

    public function register(Request $request)
    {
    	$data = $request->session()->get('facebookUser');

    	$username = $request->input('username');

    	$user = User::create([
    		'name' => $data->name,
    		'email' => $data->email,
    		'avatar' => $data->avatar,
    		'username' => $username,
    		'password' => str_random(16),
    	]);

    	$profile = SocialProfile::create([
    		'social_id' => $data->id,
    		'user_id' => $user_id,
    	]);

    	auth()->login($user);

    	return redirect('/');
    }
}
