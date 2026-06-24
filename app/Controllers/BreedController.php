<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\BreedService;
use CodeIgniter\HTTP\ResponseInterface;

class BreedController extends BaseController
{
    private BreedService $breedService;

    public function __construct() {
        $this->breedService = service('breed');
    }

    public function index()
    {
        // [] listar as raças
    }

    public function create()
    {
        // [] view breed/create
    }

    public function store()
    {
        // [] inserir nova raça no bd
    }

    public function edit(int $id)
    {
        // [] view breed/edit
    }

    public function update(int $id)
    {
        // [] atualizar raça do bd de acordo com o id
    }

    public function delete(int $id)
    {
        // [] deletar raça do bd de acordo com o id
    }
}
