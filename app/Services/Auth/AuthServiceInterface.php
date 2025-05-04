<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function login(array $credentials);
    public function register(array $data);
    public function logout();
    public function kirimEmail(array $email);
    public function resetPassword(array $data);
    public function kirimEmailToken(string $email);
    public function validasiTokenResetPassword(string $token);
}
