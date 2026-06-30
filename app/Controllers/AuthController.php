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

        $user = new UserModel();
        $userFound = $user->where('email', $email)->first();

        if (!$userFound) {
            session()->setFlashdata('error', 'Não encontramos seu email.');
            return redirect()->back()->withInput();
        }

        $expires = new DateTime();
        $expires->modify('+5 minutes');

        $token = md5(uniqid());
        $user->where('id', $userFound['id'])
            ->set([
                'reset_token' => $token,
                'reset_expires_at' => $expires->format('Y-m-d H:i:s')
            ])
            ->update();


        $mail = new Mail;
        $mail->setFrom([
            'name' => 'Faro Animal',
            'email' => 'bianca.fontes.dev@gmail.com',
        ]);
        $mail->setTo($email);
        $mail->setSubject('Recuperação de senha');
        $mail->setTemplate('emails/reset', [
            'name' => $userFound['name'],
            'token' => $token,
        ]);

        ($mail->send()) ?
            session()->setFlashdata('forgot_sent', 'Enviamos um link de recuperação se senha para o seu e-mail.') :
            session()->setFlashdata('forgot_not_sent', 'Ocorreu um erro ao enviar o e-mail. Tente novamente em alguns segundos.');

        return redirect()->back()->withInput();
    }

    public function resetPassword(string $token)
    {
        if (!$token) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');
            return redirect()->route('forgot');
        }

        $user = new UserModel();
        $userFound = $user->where('reset_token', $token)->first();

        if (!$userFound) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');
            return redirect()->route('forgot');
        }

        $expiration = new DateTime($userFound['reset_expires_at']);
        $now = new DateTime('now');

        if ($now > $expiration) {
            session()->setFlashdata('token_not_found', 'Token não existe ou não é válido.');
            return redirect()->route('forgot');
        }

        return view('reset', [
            'title' => 'Recuperação de senha',
            'token' => $token,
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
