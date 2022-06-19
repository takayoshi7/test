<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Emp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9!-\/:-@¥[-`{_~?]+$/', 'unique:emp'],
            'empno' => ['required', 'integer', 'regex:/^([1-9][0-9]{3}$)/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:emp'],
            'password' => ['required', 'confirmed', 'regex:/^[a-zA-Z0-9!-\/:-@¥[-`{_~?]{8,}+$/', Rules\Password::defaults()],
        ]);

        $user = Emp::create([
            'id' => $request->id,
            'empno' => $request->empno,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
