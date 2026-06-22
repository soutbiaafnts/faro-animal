<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('login', $data);
    }

    public function login()
    {
        $authService = service('auth');

        $result = $authService->auth($this->request->getPost());

        if (!$result['success']) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $result['errors']);
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        $authService = service('auth');
        $authService->logout();

        return redirect()->route('home');
    }

    public function forgotPassword()
    {
        // todo: view auth/forgot-password
    }

    public function sendResetLink()
    {
        // todo: enviar email
    }

    public function resetPassword(string $token)
    {
        // todo: view auth/reset-password
    }

    public function updatePassword()
    {
        // todo: salva a nova senha
    }
}
