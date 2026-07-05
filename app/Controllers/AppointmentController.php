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
        $result = $this->appointmentService->getAllAppointments();

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('appointments/list', [
            'title' => 'Consultas',
            'message' => $result['message'],
            'appointments' => $result['data'],
        ]);
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
        $result = $this->appointmentService->createAppointment([
            'pet_id' => $this->request->getPost('pet_id'),
            'user_id' => session()->get('user_id'),
            'appointment_date' => $this->request->getPost('appointment_date'),
            'status' => $this->request->getPost('status'),
            'reason' => $this->request->getPost('reason'),
            'diagnosis' => $this->request->getPost('diagnosis'),
            'prescription' => $this->request->getPost('prescription'),
            'notes' => $this->request->getPost('notes'),
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('appointments')->with('message', $result['message']);
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
