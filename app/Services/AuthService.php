<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function validateAuth(array $data): array
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

    public function auth(array $data): array
    {
        $validation = $this->validateAuth($data);

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
}
