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
        // todo: remover d() e colocar os retornos

        $authService = service('auth');

        $result = $authService->auth($this->request->getPost());

        if (!$result['success']) {
            d($result['errors']);
        }

        d($result['success']);
    }

    public function logout() {
        // todo: encerra a sessão

        $authService = service('auth');

        $authService->logout();
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
