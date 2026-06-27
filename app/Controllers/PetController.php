<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\BreedService;
use App\Services\PetService;
use CodeIgniter\HTTP\ResponseInterface;

class PetController extends BaseController
{
    private PetService $petService;
    private BreedService $breedService;

    public function __construct() {
        $this->petService = service('pet');
        $this->breedService = service('breed');
    }

    public function index()
    {
        // todo: listar as pets
    }

    public function create()
    {
        
    }

    public function store()
    {
        // todo: inserir novo pet no bd
    }

    public function edit(int $id)
    {
        // todo: view pet/edit
    }

    public function update(int $id)
    {
        // todo: atualizar pet do bd de acordo com o id
    }

    public function delete(int $id)
    {
        // todo: deletar pet do bd de acordo com o id
    }
}
