<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function show()
    {
        return view('auth.register');
    }



    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'phone' => 'nullable|string|max:20',

            'role' => 'required|in:user,organizer',

            'password' => 'required|min:6|confirmed',

        ], [

            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',

            'email.email' => 'Format email tidak valid.',

            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',

            'role.required' => 'Role wajib dipilih.',

            'role.in' => 'Role tidak valid.',

            'password.required' => 'Password wajib diisi.',

            'password.min' => 'Password minimal 6 karakter.',

            'password.confirmed' => 'Konfirmasi password tidak cocok.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK EMAIL AGAIN
        |--------------------------------------------------------------------------
        */

        $checkUser = User::where('email', $validated['email'])->first();

        if ($checkUser) {

            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Akun dengan email tersebut sudah ada.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        $user = new User();

        $user->name = $validated['name'];

        $user->email = $validated['email'];

        $user->phone = $validated['phone'] ?? null;

        $user->role = $validated['role'];

        $user->password = Hash::make($validated['password']);

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | REFRESH USER DATA
        |--------------------------------------------------------------------------
        */

        $user = User::find($user->id);


        /*
        |--------------------------------------------------------------------------
        | LOGOUT USER AFTER REGISTER
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | INVALIDATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with('success', 'Akun ' . $user->role . ' berhasil dibuat! Silakan login.');
    }
}