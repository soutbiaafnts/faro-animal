<?php

namespace App\Services;

use App\Models\PetModel;
use App\Models\SpecieModel;

class PetService {
    protected PetModel $petModel;
    protected SpecieModel $specieModel;

    public function __construct() {
        $this->petModel = new PetModel();
    }

    // NOTE: validações
    private function validateCreatePet(array $data): array {
        $validation = service('validation');

        $validation->setRules([
            'breed_id' => 'required|integer',
            'name' => 'required|min_length[3]|max_length[100]',
            'sex' => 'required|in_list[F,M]',
            'birth_date' => 'required|valid_date[Y-m-d]',
            'weight' => 'required|greater_than[0]',
            'notes' => 'min_length[3]|max_length[1000]',
            'owner_name' => 'required|min_length[3]|max_length[120]',
            'owner_phone' => 'regex_match[/^\([1-9]{2}\) 9[0-9]{4}-[0-9]{4}$/]',
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
                'min_length' => 'O nome do tutor precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome do tutor precisa ter no máximo 120 caracteres.',
            ],
            'owner_phone' => [
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

        if (strtotime($data['birth_date']) > strtotime(date('Y-m-d'))) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'birth_date' => 'A data não pode ser futura.'
                ],
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

    private function validateUpdatePet(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'sex' => 'required|in_list[F,M]',
            'birth_date' => 'required|valid_date[Y-m-d]',
            'weight' => 'required|greater_than[0]',
            'notes' => 'min_length[3]|max_length[1000]',
            'owner_name' => 'required|min_length[3]|max_length[120]',
            'owner_phone' => 'regex_match[/^\([1-9]{2}\) 9[0-9]{4}-[0-9]{4}$/]',
        ], [
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
                'min_length' => 'O nome do tutor precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome do tutor precisa ter no máximo 120 caracteres.',
            ],
            'owner_phone' => [
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

        if (strtotime($data['birth_date']) > strtotime(date('Y-m-d'))) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'birth_date' => 'A data não pode ser futura.'
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
     * Summary of createPet
     *
     * @param array $data
     * @return array
     */
    public function createPet(array $data): array
    {
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
                'message' => 'Erro ao criar pet.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of getAllPets
     *
     * @return array
     */
    public function getAllPets(): array {
        try {
            $pets = $this->petModel
                ->select('pets.*, breeds.name AS breed_name')
                ->join('breeds', 'breeds.id = pets.breed_id', 'left')
                ->findAll();

            if (!$pets) {
                return [
                    'success' => false,
                    'message' => 'Nenhum pet encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'data' => $pets,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar pets.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of getPetById
     *
     * @param integer $id
     * @return array
     */
    public function getPetById(int $id): array {
        try {
            $petFound = $this->petModel
                ->select('
                pets.*,
                breeds.name AS breed_name,
                species.id AS species_id,
                species.name AS specie_name
                ')
                ->join('breeds', 'breeds.id = pets.breed_id')
                ->join('species', 'species.id = breeds.species_id')
                ->find($id);

            if (!$petFound) {
                return [
                    'success' => false,
                    'message' => 'Pet não encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'data' => $petFound,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar pet.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of updatePet
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function updatePet(int $id, array $data): array {
        try {
            $validation = $this->validateUpdatePet($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->petModel->update($id, $data);

            return [
                'success' => true,
                'message' => 'Pet editada com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao editar raça.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of deletePet
     *
     * @param integer $id
     * @return array
     */
    public function deletePet(int $id): array {
        try {
            $pet = $this->petModel->find($id);

            if (!$pet) {
                return [
                    'success' => false,
                    'message' => 'Pet não encontrado.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $this->petModel->delete($id);

            return [
                'success' => true,
                'message' => 'Pet excluído com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir pet.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}
