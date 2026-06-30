<?php

namespace App\Services;

use App\Libraries\Mail;
use App\Models\UserModel;
use DateTime;

class AuthService
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function validateAuthData(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required',
        ], [
            'email' => [
                'required' => 'O campo e-mail é obrigatório.',
                'valid_email' => 'E-mail inválido.',
            ],
            'password' => [
                'required' => 'O campo senha é obrigatório.',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function validateSendEmailData(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'email' => 'required',
        ], [
            'email' => [
                'required' => 'Informe seu e-mail.',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        try {
            $userFound = $this->userModel->where('email', $data['email'])->first();

            if (!$userFound) {
                return [
                    'success' => false,
                    'message' => 'Erro ao buscar usuário',
                    'invalidArgs' => [
                        'email' => 'Não existe um usuário com este e-mail.'
                    ],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'user' => $userFound,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar usuário: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function auth(array $data): array
    {
        $validation = $this->validateAuthData($data);

        if (!$validation['success']) {
            return $validation;
        }

        // validação do usuário
        $userFound = $this->userModel
            ->where('email', $data['email'])
            ->first();

        if (!$userFound) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'email' => 'E-mail ou senha incorretos.'
                ],
                'errors' => null,
            ];
        }

        if (!password_verify($data['password'], $userFound['password'])) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'email' => 'E-mail ou senha incorretos.'
                ],
                'errors' => null,
            ];
        }

        session()->set([
            'user_id' => $userFound['id'],
            'user_name' => $userFound['name'],
            'user_email' => $userFound['email'],
            'auth' => true,
        ]);

        return [
            'success' => true,
            'user' => $userFound,
        ];
    }

    public function logout()
    {
        session()->destroy();
    }

    public function createResetToken(array $user): array
    {
        $expires = new DateTime();
        $expires->modify('+5 minutes');

        $token = bin2hex(random_bytes(32));

        try {
            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_espires_at' => $expires->format('Y-m-d H:i:s'),
            ]);

            return [
                'success' => true,
                'expires' => $expires,
                'token' => $token
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar token.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }

    }

    public function sendTokenLink(array $data):array
    {
        $validation = $this->validateSendEmailData($data);

        if (!$validation['success']) {
            return [
                'success' => false,
                'message' => $validation['message'],
                'invalidArgs' => $validation['invalidArgs'],
                'errors' => $validation['errors'],
            ];
        }

        $userFound = $validation['user'];

        $resetToken = $this->createResetToken($userFound);

        if (!$resetToken['success']) {
            return [
                'success' => false,
                'message' => $resetToken['message'],
                'invalidArgs' => $resetToken['invalidArgs'],
                'errors' => $resetToken['errors'],
            ];
        }

        try {
            $mail = new Mail();
            $mail->setFrom([
                'name' => 'Faro Animal',
                'email' => 'resetpass@faroanimal.com',
            ]);
            $mail->setTo($userFound['email']);
            $mail->setSubject('Redefinição de senha');
            $mail->setTemplate('emails/reset', [
                'name' => $userFound['name'],
                'token' => $resetToken['token'],
            ]);

            if (!$mail->send()) {
                return [
                    'success' => false,
                    'message' => 'Erro ao enviar e-mail, tente novamente em alguns segundos.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Enviamos um link de redefinição se senha para o seu e-mail!'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao enviar e-mail: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}
