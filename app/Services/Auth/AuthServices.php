<?php

namespace App\Services\Auth;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordResetToken;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Mail;

class AuthServices implements AuthServiceInterface
{
    // Login Method
    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            Alert::success('Success', 'Login successful!');
            return redirect()->route('dashboard');
        }

        Alert::error('Error', 'Invalid email or password!');
        return back();
    }

    // Logout Method
    public function logout()
    {
        Auth::logout();
        Alert::success('Success', 'Logout successful!');
        return redirect()->route('login');
    }

    // Register Method
    public function register(array $data)
    {
        $role = Roles::where('name', 'Author')->first();
        $data['role_id'] = $role->id;
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
        ]);

        Alert::success('Success', 'Registration successful! Please login.');
        return redirect()->route('login');
    }

    public function kirimEmail(array $email)
    {
        $email = $email['email'];
        $token = Str::random(60);
        // Hapus token lama jika ada
        PasswordResetToken::where('email', $email)->delete();

        PasswordResetToken::create([
            "email" => $email,
            "token" => $token,
            "created_at" => now()
        ]);
            
            
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function resetPassword(array $data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $password = Hash::make($password);
        return User::where('email', $email)->update([
            'password' => $password
        ]);
    }

    public function prosesLupaPassword(array $data)
    {
        // give me code for proses update password
        // give me code for proses update password
        $email = $data['email'];
        $password = $data['password'];
        $password = Hash::make($password);
        User::where('email', $email)->update([
            'password' => $password
        ]);
        Alert::success('Success', 'Password berhasil direset!');
    }

    public function validasiTokenResetPassword(string $token)
    {
        $cekToken = PasswordResetToken::where('token', $token)->first();
        if ($cekToken) {
            return view('auth.reset-password-validasi', compact('token', 'email'));
        }
        return redirect()->route('lupa-password');
    }
}
