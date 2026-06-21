<?php

namespace App\Services;

use App\Models\UserModel;

class UserService {
    protected UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    private function validateUserData(array $data): void {
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ], [
            'name' => [
                'required' => 'O campo nome é obrigatório.',
                'min_length[3]' => 'O nome precisa ter pelo menos 3 caracteres.',
                'max_length[120]' => 'O nome precisa ter no máximo 120 caracteres.',
            ],
            'email' => [
                'required' => 'O campo email é obrigatório.',
                'valid_email' => 'E-mail inválido.',
                'is_unique' => 'E-mail já cadastrado.',
            ],
            'password' => [
                'required' => 'O campo email é obrigatório.',
                'min_length[8]' => 'A senha precisa ter no mínimo 8 caracteres.',
            ],
        ]);

        if (!$validation->run($data)) {
            throw new \InvalidArgumentException(
                json_decode($validation->getErrors())
            );
        }
    }

    public function getUserById(int $id) {
        try {
            $user = $this->userModel->find($id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
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
                'message' => 'Erro ao buscar usuário: ' . $e->getMessage(),
            ];
        }
    }

    public function getAllUsers() {
        try {
            $users = $this->userModel->paginate(10);
            $pager = $this->userModel->pager;

            return [
                'success' => true,
                'pager' => $pager,
                'data' => $users,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar usuários: ' . $e->getMessage()
            ];
        }

    }
}