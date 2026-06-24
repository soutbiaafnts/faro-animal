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
            $breeds = $this->breedModel->paginate(10);
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
}