<?php

namespace App\Services;

use App\Models\BreedModel;

class BreedService {
    protected BreedModel $breedModel;

    public function __construct() {
        $this->breedModel = new BreedModel();
    }
}