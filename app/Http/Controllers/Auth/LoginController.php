<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function index()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => now(),
        ]);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $data = Socialite::driver('google')->user();

        if (!($user = User::whereEmail($data->email)->first())) {
            $password = Str::password(12);
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => bcrypt($password),
                'default_password' => $password,
            ]);
        }

        Auth::login($user);

        return $this->sendLoginResponse($request);
    }
}
