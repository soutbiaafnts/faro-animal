<?php

namespace App\Services;

use App\Models\SpecieModel;

class SpecieService {
    protected SpecieModel $specieModel;

    public function __construct() {
        $this->specieModel = new SpecieModel();
    }
}