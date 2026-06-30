<?php

namespace App\Controllers;

use App\Services\AuthService;

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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function forgotPassword()
    {
        return view('forgot', ['title' => 'Esqueci a senha']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
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
        $result = $this->authService->sendToken($token);

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
        ]);
    }

    /**
     * Summary of updatePassword
     *
     * @param string $token
     * @return void
     */
    public function updatePassword(string $token){
        $password = $this->request->getPost('password');
        $confirmPass = $this->request->getPost('confirmPass');

        $result = $this->authService->updatePassword($token, $password, $confirmPass);

        if (!$result['success']) {
            return redirect()->back()
                ->with('success', $result['success'])
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('forgot')->with('success', $result['success'])->with('message', $result['message']);
    }
}
