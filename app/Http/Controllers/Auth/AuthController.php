<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\AuthServices;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LupaPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Auth\AuthServices as AuthAuthServices;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthAuthServices $authService)
    {
        $this->authService = $authService;
    }

    public function halamanRegister()
    {
        return view('auth.register');
    }

    public function halamanLogin()
    {
        return view('auth.login');
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function login(LoginRequest $request)
    {
        Alert::success('Success', 'Login successfully');
        return $this->authService->login($request->validated());
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function halamanLupaPassword()
    {
        return view('auth.reset-password');
    }

    public function kirimEmail(LupaPasswordRequest $request)
    {
        
        $this->authService->kirimEmail($request->validated());
        Alert::success('Success', 'Email berhasil dikirim!');
        return redirect()->route('lupa-password');
    }

    public function halamanUpdatePassword($token)
    {
        return view('auth.new-password',['token' => $token]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if ($request->password != $request['password_confirmation']) {
            Alert::error('Error', 'Password tidak sama!');
            return redirect()->route('process.lupa-password.token',$request['token']);
        }
        $this->authService->resetPassword($request->validated());
        Alert::success('Success', 'Password berhasil direset!');
        return redirect()->route('login');
    }

    public function prosesLupaPassword(Request $request)
    {
        $this->authService->prosesLupaPassword($request->validated());
        return redirect()->route('login');
    }

    public function validasiTokenResetPassword(Request $request)
    {
        $this->authService->validasiTokenResetPassword($request->validated());

    }

}
