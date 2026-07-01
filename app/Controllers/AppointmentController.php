<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AppointmentService;
use App\Services\PetService;

class AppointmentController extends BaseController
{
    private AppointmentService $appointmentService;
    private PetService $petService;
    
    public function __construct()
    {
        $this->appointmentService = service('appointment');
        $this->petService = service('pet');
    }

    public function index()
    {
        // todo: listar as consultas
    }

    public function create()
    {
        $result = $this->petService->getAllPets();

        if (!$result['success']) {
            return redirect()->back()->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('appointments/create', [
            'title' => 'Nova Consulta',
            'pets' => $result['pets'],
        ]);;
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
