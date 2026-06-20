<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PetController extends BaseController
{
    public function index()
    {
        // todo: listar as pets
    }

    public function create()
    {
        // todo: view pet/create
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
