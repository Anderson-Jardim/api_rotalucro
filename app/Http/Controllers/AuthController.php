<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Rules\Contact;

class AuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'contact' => ['required', 'string', 'max:255', new Contact],
            'password' => 'required|min:6|confirmed'
        ]);

        //create user
        $user = User::create([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
            'contact' => $attrs['contact'],
            'password' => bcrypt($attrs['password'])
        ]);

        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    // login user
    public function login(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'contact' => ['required', new Contact],
            'password' => 'required|min:6'
        ]);

        // attempt login
        if(!Auth::attempt($attrs))
        {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        //return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    // logout user
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    // get user details
    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // update user
    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'contact' => ['required', 'string', 'max:255', new Contact],
            'password' => 'required|min:6|confirmed'
        ]);

        //$image = $this->saveImage($request->image, 'profiles');

        auth()->user()->update([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
            'contact' => $attrs['contact'],
            'password' => bcrypt($attrs['password'])
        ]);

        return response([
            'message' => 'User updated.',
            'user' => auth()->user()
        ], 200);
    }

}
