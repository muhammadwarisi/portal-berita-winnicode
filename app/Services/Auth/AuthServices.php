<?php

namespace App\Services\Auth;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordResetToken;
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
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
        // dd($email);
        // Simpan token baru
        PasswordResetToken::create([
            "email" => $email,
            "token" => $token,
            "created_at" => now()
        ]);
            
            // dd($email,$token);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function resetPassword(array $data)
    {

    }

    public function kirimEmailToken(string $email)
    {

    }

    public function validasiTokenResetPassword(string $token)
    {
        
    }
}
