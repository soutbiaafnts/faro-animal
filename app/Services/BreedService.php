<?php

namespace App\Services;

use App\Models\BreedModel;

class BreedService {
    protected BreedModel $breedModel;

    public function __construct() {
        $this->breedModel = new BreedModel();
    }

    public function getAllBreeds() {
        try {
            $breeds = $this->breedModel
                ->select('breeds.*, species.name AS specie_name')
                ->join('species', 'species.id = breeds.species_id', 'left')
                ->paginate(10);
            $pager = $this->breedModel->pager;

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'pager' => $pager,
                'breeds' => $breeds,
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

    // - VALIDAÇÕES
    private function validateCreateBreed(array $data): array {
        $validation = service('validation');

        $validation->setRules([
            'species_id' => 'required|integer',
            'name' => 'required|min_length[3]|max_length[100]',
        ], [
            'species_id' => [
                'required' => 'Este campo obrigatório.',
                'integer' => 'A raça precisa ser um número inteiro.',
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

        return [
            'success' => true,
        ];
    }
}