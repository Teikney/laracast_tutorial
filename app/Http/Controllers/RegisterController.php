<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $user = User::create( request()->validate([
            'name'      =>  'required|max:255',
            'username'  =>  'required|max:255|min:3|unique:users,username',     //another way to validate if the username already exists is ==> 'username'  =>  ['required','max:255','min:3', Rule::unique('users','username')],
            'email'     =>  'required|email|max:255|unique:users,email',
            'password'  =>  'required|min:7|max:255'
        ]));

        //log the user in
        auth()->login($user);

        return redirect('/')->with('success','Your account has been created!');
    }
}