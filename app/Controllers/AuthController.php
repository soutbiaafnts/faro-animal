<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        // todo: view auth/login
    }

    public function login() {
        // todo: processa o formulário
    }

    public function logout() {
        // todo: encerra a sessão
    }

    public function forgotPassword() {
        // todo: view auth/forgot-password
    }

    public function sendResetLink() {
        // todo: enviar email
    }

    public function resetPassword(string $token) {
        // todo: view auth/reset-password
    }

    public function updatePassword() {
        // todo: salva a nova senha
    }
}
