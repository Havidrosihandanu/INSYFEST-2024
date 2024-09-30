<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan ada view ini
    }

    /**
     * Handle user registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'nama_lengkap' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:15',
            'jenjang' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat pengguna baru
        $user = User::create([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_hp' => $request->nomor_hp,
            'jenjang' => $request->jenjang,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect setelah sukses
        return redirect()->route('login')->with('success', 'User registered successfully. Please log in.');
    }
}
