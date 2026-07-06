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

    // NOTE: Validações

    private function validateAuthData(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required',
        ], [
            'email' => [
                'required' => 'Este campo é obrigatório.',
                'valid_email' => 'E-mail inválido.',
            ],
            'password' => [
                'required' => 'Este campo é obrigatório.',
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

    private function validateSendEmailData(array $data): array
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
                'data' => $userFound,
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

    private function validateNewPassword(array $data): array
    {
        $validation = service('validation');
        $validation->setRules([
            'password' => 'required|min_length[8]|matches[confirmPass]',
            'confirmPass' => 'required',
        ], [
            'password' => [
                'required' => 'Defina uma nova senha.',
                'min_length' => 'A nova senha deve possuir pelo menos 8 caracteres',
                'matches' => 'As senhas não coincidem.',
            ],
            'confirmPass' => [
                'required' => 'Confirme a senha.'
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

        return ['success' => true];
    }

    // NOTE: lógica de autenticação

    /**
     * Summary of auth
     *
     * @param array $data
     * @return array
     */
    public function auth(array $data): array
    {
        $validation = $this->validateAuthData($data);

        if (!$validation['success']) {
            return $validation;
        }

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

    /**
     * Summary of logout
     * @return void
     */
    public function logout()
    {
        session()->destroy();
    }

    /**
     * Summary of createResetToken
     * @param array $user
     * @return array
     */
    public function createResetToken(array $user): array
    {
        $expires = new DateTime();
        $expires->modify('+5 minutes');

        $token = bin2hex(random_bytes(32));

        try {
            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires_at' => $expires->format('Y-m-d H:i:s'),
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

    /**
     * Summary of sendTokenLink
     * @param array $data
     * @return array
     */
    public function sendTokenLink(array $data): array
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

        $userFound = $validation['data'];

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
                'message' => 'Enviamos um link de redefinição de senha para o seu e-mail!'
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

    /**
     * Summary of sendToken
     * @param string $resetToken
     * @return array
     */
    public function sendToken(string $resetToken)
    {
        if (!$resetToken) {
            return [
                'success' => false,
                'message' => 'Token inexistente ou inválido.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        try {
            $userFound = $this->userModel->where('reset_token', $resetToken)->first();

            if (!$userFound) {
                return [
                    'success' => false,
                    'message' => 'Token inexistente ou inválido.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $expiration = new DateTime($userFound['reset_expires_at']);
            $now = new DateTime('now');

            if ($now > $expiration) {
                return [
                    'success' => false,
                    'message' => 'Token inexistente ou inválido.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return ['success' => true];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao enviar e-mail: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    

    /**
     * Summary of updatePassword
     *
     * @param string $resetToken
     * @param string $newPassword
     * @param string $confirmPass
     * @return array
     */
    public function updatePassword(string $resetToken, string $newPassword, string $confirmPass): array
    {
        $validation = $this->validateNewPassword([
            'password' => $newPassword,
            'confirmPass' => $confirmPass,
        ]);

        if (!$validation['success']) {
            return [
                'success' => false,
                'message' => $validation['message'],
                'invalidArgs' => $validation['invalidArgs'],
                'errors' => $validation['errors'],
            ];
        }

        try {
            $userFound = $this->userModel->where('reset_token', $resetToken)->first();

            if (!$userFound) {
                return [
                    'success' => false,
                    'message' => 'Token inexistente ou inválido.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $userUpdated = $this->userModel->update($userFound['id'], [
                'password' => $newPassword,
                'reset_token' => null,
                'reset_expires_at' => null,
            ]);

            if (!$userUpdated) {
                return [
                    'success' => false,
                    'message' => 'Erro ao redefinir a senha.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Senha redefinida com sucesso',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao redefinir a senha.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}
