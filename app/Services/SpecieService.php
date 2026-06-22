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

        $validation->setRules([
            'name' => 'required|min_length[3]|is_unique[species.name]',
        ], [
            'name' => [
                'required' => 'Este campo é obrigatório.',
                'min_length' => 'O nome precisa ter pelo menos 3 caracteres.',
                'is_unique' => 'Espécie já cadastrada.'
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
}