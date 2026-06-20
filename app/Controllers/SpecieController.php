<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SpecieController extends BaseController
{
    public function index()
    {
        // todo: listar as espécies
    }

    public function create() {
        // todo: view specie/create
    }

    public function store() {
        // todo: inserir nova espécie no bd
    }

    public function edit(int $id) {
        // todo: view specie/edit
    }

    public function update(int $id) {
        // todo: atualizar espécie do bd de acordo com o id
    }

    public function delete(int $id) {
        // todo: deletar espécie do bd de acordo com o id
    }
}
