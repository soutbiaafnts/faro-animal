<?php

namespace App\Services;

use App\Models\BreedModel;

class BreedService {
    protected BreedModel $breedModel;

    public function __construct() {
        $this->breedModel = new BreedModel();
    }

    // NOTE: validações

    private function validateCreateBreed(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'species_id' => 'required|integer',
            'name' => 'required|min_length[3]|max_length[100]',
        ], [
            'species_id' => [
                'required' => 'Este campo obrigatório.',
                'integer' => 'o id da raça precisa ser um número inteiro.',
            ],
            'name' => [
                'required' => 'Este campo obrigatório.',
                'min_length' => 'O nome da raça precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome da raça precisa ter no máximo 100 caracteres.',
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

        $existing = $this->breedModel
            ->where('name', $data['name'])
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'verifique os campos.',
                'invalidArgs' => [
                    'name' => 'Raça já cadastrada.'
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
     * Summary of createBreed
     *
     * @param array $data
     * @return array
     */
    public function createBreed(array $data): array
    {
        try {
            $validation = $this->validateCreateBreed($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $newBreed = [
                'species_id' => $data['species_id'],
                'name' => $data['name'],
            ];

            $this->breedModel->insert($newBreed);

            return [
                'success' => true,
                'message' => 'Raça cadastrada com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar raça.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of getAllBreeds
     *
     * @return array
     */
    public function getAllBreeds(): array {
        try {
            $breeds = $this->breedModel
                ->select('breeds.*, species.name AS specie_name')
                ->join('species', 'species.id = breeds.species_id', 'left')
                ->findAll();

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'data' => $breeds,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar raças.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of getBreedById
     *
     * @param integer $id
     * @return array
     */
    public function getBreedById(int $id): array {
        try {
            $breedFound = $this->breedModel
                ->select('breeds.*, species.name as specie_name')
                ->join('species', 'species_id = breeds.species_id')
                ->find($id);

            if (!$breedFound) {
                return [
                    'success' => false,
                    'message' => 'Raça não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $breed = [
                'id' => $breedFound['id'],
                'name' => $breedFound['name'],
                'species_id' => $breedFound['species_id'],
                'specie_name' => $breedFound['specie_name'],
            ];

            return [
                'success' => true,
                'data' => $breed,
            ];
       } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar espécie.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ]; 
       }
    }

    /**
     * Summary of getBreedBySpecie
     *
     * @param integer $specieId
     * @return array
     */
    public function getBreedsBySpecie(int $specieId): array {
        try {
            $breedsFound = $this->breedModel->select('id, name')->where('species_id', $specieId)->findAll();

            if (!$breedsFound) {
                return [
                    'success' => false,
                    'message' => 'Nenhuma raça encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'data' => $breedsFound,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar raças.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary of updateBreed
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function updateBreed(int $id, array $data): array {
        try {
            $validation = $this->validateCreateBreed($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->breedModel->update($id, [
                'name' => $data['name'],
                'species_id' => $data['species_id'],
            ]);

            return [
                'success' => true,
                'message' => 'Raça editada com sucesso!',
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
     * Summary of deleteBreed
     *
     * @param integer $id
     * @return array
     */
    public function deleteBreed(int $id): array {
        try {
            $breed = $this->breedModel->find($id);

            if (!$breed) {
                return [
                    'success' => false,
                    'message' => 'Raça não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $this->breedModel->delete($id);

            return [
                'success' => true,
                'message' => 'Raça excluída com sucesso!',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir raça.',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}