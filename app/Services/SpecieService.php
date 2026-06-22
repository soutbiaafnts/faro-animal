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
}