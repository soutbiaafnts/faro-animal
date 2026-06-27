<?php

namespace App\Services;

use App\Models\PetModel;

class PetService {
    protected PetModel $petModel;

    public function __construct() {
        $this->petModel = new PetModel();
    }

    // - VALIDAÇÕES
    private function validateCreatePet(array $data): array {
        $validation = service('pet');

        $validation->setRules([
            'breed_id' => 'required|integer',
            'name' => 'required|min_length[3]|max_length[100]',
            'sex' => 'required|in_list[F,M]',
            'birth_date' => 'required|valid_date[Y-m-d]|before_date[today]',
            'weight' => 'required|greater_than[0]',
            'notes' => 'min_length[3]|max_length[5000]',
            'owner_name' => 'required|min_length[3]|max_length[120]',
            // [] pesquisar mais sobre o regex para telefone
            'owner_phone' => 'exact_length[11]|regex_match[/^\([1-9]{2}\) 9[0-9]{4}-[0-9]{4}$/]',
        ], [
            'breed_id' => [
                'required' => 'Este campo é obrigatório.',
                'integer' => 'O id da raça precisa ser um número inteiro.'
            ],
            'name' => [
                'required' => 'Este campo é obrigatório.',
                'min_length' => 'O nome precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome precisa ter no máximo 100 caracteres.',
            ],
            'sex' => [
                'required' => 'Este campo é obrigatório.',
                'in_list' => 'O sexo precisa ser F ou M.',
            ],
            'birth_date' => [
                'required' => 'Este campo é obrigatório.',
                'valid_date' => 'Data inválida.',
                'before_date' => 'A data não pode ser futura.',
            ],
            'weight' => [
                'required' => 'Este campo é obrigatório.',
                'greater_than' => 'O peso precisa ser maior que zero',
            ],
            'notes' => [
                'min_length' => 'A nota precisa ter pelo menos 3 caracteres.',
                'max_length' => 'A nota precisa ter no máximo 5000 caracteres.',
            ],
            'owner_name' => [
                'required' => 'Este campo é obrigatório.',
                'min_length' => 'O nome do dono precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome do dono precisa ter no máximo 120 caracteres.',
            ],
            'owner_phone' => [
                'min_length' => 'O número do dono precisa ter pelo menos 10 caracteres.',
                'max_length' => 'O número do dono precisa ter no máximo 11 caracteres.',
                'regex_match' => 'Número de telefone inválido.',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        $existing = $this->petModel
            ->where('name', $data['name'])
            ->where('owner_name', $data['owner_name'])
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Verifique os campos',
                'invalidArgs' => [
                    'name' => 'Pet já cadastrado.'
                ],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function createPet(array $data) {
        try {
            $validation = $this->validateCreatePet($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->petModel->insert($data);

            return [
                'success' => true,
                'message' => 'Pet criado com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar pet: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}