<?php

namespace App\Controllers;

use App\Libraries\Mail;
use App\Models\UserModel;
use App\Services\AuthService;
use DateTime;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = service('auth');
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('login', $data);
    }

    public function login()
    {
        $result = $this->authService->auth($this->request->getPost());

        if (!$result['success']) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('home');
    }

    public function forgotPassword()
    {
        return view('forgot', ['title' => 'Esqueci a senha']);
    }

    public function sendResetLink()
    {
        $email = $this->request->getPost('email');

        $result = $this->authService->sendTokenLink([
            'email' => $email,
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('success', $result['success'])
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }
        return redirect()->back()->withInput()->with('success', $result['success'])->with('message', $result['message']);
    }

    /**
     * Summary of resetPassword
     * @param string $token
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function resetPassword(string $token)
    {
        $result = $this->authService->validateToken($token);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('success', $result['success'])
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('reset', [
            'title' => 'Recuperação de senha',
            'token' => $token,
            'success' => $result['success'],
            'message' => $result['message'],
        ]);
    }

    public function updatePassword(string $token)
    {
        $password = $this->request->getPost('password');

        $user = new UserModel();
        $userFound = $user->where('reset_token', $token)->first();

        if (!$userFound) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');
            return redirect()->route('forgot');
        }

        $updated = $user->update($userFound['id'], [
            'password' => $password,
            'reset_token' => null,
            'reset_expires_at' => null,
        ]);

        d($updated);

        ($updated) ?
            session()->setFlashdata('updated', 'Senha atualizada com sucesso!') :
            session()->setFlashdata('not_updated', 'A senha não foi atualizada.');

        return redirect()->route('forgot');
    }
}
