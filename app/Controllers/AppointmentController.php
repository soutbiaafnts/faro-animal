<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AppointmentService;

class AppointmentController extends BaseController
{
    private AppointmentService $appointmentService;
    
    public function __construct()
    {
        $this->appointmentService = service('appointment');
    }

    public function index()
    {
        // todo: listar as consultas
    }

    public function create()
    {
        // todo: view appointment/create
    }

    public function store()
    {
        // todo: inserir nova consulta no bd
    }

    public function edit(int $id)
    {
        // todo: view appointment/edit
    }

    public function update(int $id)
    {
        // todo: atualizar consulta do bd de acordo com o id
    }

    public function delete(int $id)
    {
        // todo: deletar consulta do bd de acordo com o id
    }
}
