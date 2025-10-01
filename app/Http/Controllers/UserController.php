<?php

namespace App\Http\Controllers;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            // 'blood_type' => ['required'],
            'location' => ['required'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required'],
            'phone' => ['required'],
            'agreement' => ['accepted']
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['role'] = 'donor';
        $attributes['status'] = UserStatusEnum::Active;



        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        Auth::login($user);
        return redirect('/dashboard');
    }
}
