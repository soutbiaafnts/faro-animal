<?php

namespace App\Services;

use App\Models\PetModel;

class PetService {
    protected PetModel $petModel;

    public function __construct() {
        $this->petModel = new PetModel();
    }
}