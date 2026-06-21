<?php

namespace App\Services;

use App\Models\UserModel;

class UserService {
    protected UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    private function validateUserData(array $data): array {
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ], [
            'name' => [
                'required' => 'O campo nome é obrigatório.',
                'min_length' => 'O nome precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome precisa ter no máximo 120 caracteres.',
            ],
            'email' => [
                'required' => 'O campo email é obrigatório.',
                'valid_email' => 'E-mail inválido.',
                'is_unique' => 'E-mail já cadastrado.',
            ],
            'password' => [
                'required' => 'O campo email é obrigatório.',
                'min_length' => 'A senha precisa ter no mínimo 8 caracteres.',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => $validation->getErrors(),
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function getUserById(int $id) {
        try {
            $user = $this->userModel->find($id);

            if (!$user) {
                return [
                    'success' => false,
                    'errors' => 'Usuário não encontrado.',
                ];
            }
            
            $data = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];

            return [
                'success' => true,
                'data' => $data, 
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => 'Erro ao buscar usuário: ' . $e->getMessage(),
            ];
        }
    }

    public function createUser(array $data) {
        try {
            $validation = $this->validateUserData($data);

            if (!$validation['success']) {
                return $validation;
            }

            $newUser = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            $this->userModel->insert($newUser);

            return [
                'success' => true,
                'message' => 'Usuário criado com sucesso.'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar usuário: ',
                'errors' => $e->getMessage(),
            ];
        }
    }
}