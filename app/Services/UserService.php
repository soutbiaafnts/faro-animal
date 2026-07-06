<?php

namespace App\Services;

use App\Models\UserModel;

class UserService {
    protected UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // NOTE: validações
    private function validateCreateUser(array $data): array {
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
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    private function validateProfileUpdate(array $data): array {
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[120]',
        ], [
            'name' => [
                'required' => 'O campo nome é obrigatório.',
                'min_length' => 'O nome precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome precisa ter no máximo 120 caracteres.',
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

    private function validatePasswordUpdate(int $id, array $data): array {
        $validation = service('validation');

        $validation->setRules([
            'currentPassword' => 'required',
            'newPassword' => 'required|min_length[8]',
            'confirmNewPassword' => 'required|matches[newPassword]',
        ], [
            'currentPassword' => [
                'required' => 'Informe sua senha atual.',
            ],
            'newPassword' => [
                'required' => 'Este campo é obrigatório.',
                'min_length' => 'A senha precisa ter no mínimo 8 caracteres.',
            ],
            'confirmNewPassword' => [
                'required' => 'Este campo é obrigatório.',
                'matches' => 'As senhas não coincidem.',
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
            $user = $this->userModel->find($id);
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }


        if (!password_verify($data['currentPassword'], $user['password'])) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'currentPassword' => 'Senha atual incorreta.',
                ],
                'errors' => null,
            ];
        }

        if (password_verify($data['newPassword'], $user['password'])) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'newPassword' => 'A nova senha deve ser diferente da senha atual.'
                ],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }


    // NOTE: crud

    /**
     * Summary of createUser
     *
     * @param array $data
     * @return array
     */
    public function createUser(array $data): array
    {
        try {
            $validation = $this->validateCreateUser($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $newUser = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            $this->userModel->insert($newUser);

            return [
                'success' => true,
                'message' => 'Usuário criado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar usuário.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of getUserById
     *
     * @param integer $id
     * @return array
     */
    public function getUserById(int $id): array {
        try {
            $user = $this->userModel->find($id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
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
                'message' => 'Erro ao buscar usuário.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    

    /**
     * Summary of updateProfile
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function updateProfile(int $id, array $data): array {
        try {
            $validation = $this->validateProfileUpdate($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->userModel->update($id, [
                'name' => $data['name']
            ]);

            return [
                'success' => true,
                'message' => 'Nome alterado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao atualizar usuário.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of updatePassword
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function updatePassword(int $id, array $data): array {
        try {
            
            $validation = $this->validatePasswordUpdate($id, $data);
            
            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->userModel->update($id, [
                'password' => $data['newPassword']
            ]);

            return [
                'success' => true,
                'message' => 'Senha alterada com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao atualizar usuário.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of deleteUser
     *
     * @param integer $id
     * @return array
     */
    public function deleteUser(int $id): array {
        try {
            $user = $this->userModel->find($id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $this->userModel->delete($id);

            return [
                'success' => true,
                'message' => 'Usuário excluído com sucesso.',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir usuário.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}