<?php

namespace App\Services;

use App\Models\SpecieModel;

class SpecieService {
    protected SpecieModel $specieModel;

    public function __construct() {
        $this->specieModel = new SpecieModel();
    }

    // ------- VALIDAÇÕES
    private function validateSpecieData(array $data): array {
        $validation = service('validation');

        // [] validar max_length[100]
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
        ], [
            'name' => [
                'required' => 'Este campo é obrigatório.',
                'min_length' => 'O nome precisa ter pelo menos 3 caracteres.',
                'max_length' => 'O nome precisa ter no máximo 100 caracteres.',
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

        $existing = $this->specieModel
            ->where('name', $data['name'])
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'name' => 'Espécie já cadastrada.'
                ],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Espécie criada com sucesso!',
        ];
    }

    // ------- CRUD
    public function getAllSpecies() {
        try {
            $species = $this->specieModel->paginate(10);
            $pager = $this->specieModel->pager;

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'pager' => $pager,
                'species' => $species,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar espécies:',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function getSpecieById(int $id): array {
        try {
            $specieFound = $this->specieModel->find($id);

            if (!$specieFound) {
                return [
                    'success' => false,
                    'message' => 'Espécie não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $specie = [
                'id' => $specieFound['id'],
                'name' => $specieFound['name'],
            ];

            return [
                'success' => true,
                'specie' => $specie,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar espécie: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function createSpecie(array $data) {
        try {
            $validation = $this->validateSpecieData($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $newSpecie = [
                'name' => $data['name'],
            ];

            $this->specieModel->insert($newSpecie);

            return [
                'success' => true,
                'message' => $validation['message'],
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar espécie: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function updateSpecie(int $id, array $data) {
        try {
            $validation = $this->validateSpecieData($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->specieModel->update($id, [
                'name' => $data['name']
            ]);

            return [
                'success' => true,
                'message' => 'Espécie alterada com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao editar espécie: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function deleteSpecie(int $id) {
        try {
            $specie = $this->specieModel->find($id);

            if (!$specie) {
                return [
                    'success' => false,
                    'message' => 'Espécie não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $this->specieModel->delete($id);

            return [
                'success' => true,
                'message' => 'Espécie excluída com sucesso!',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir espécie',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}