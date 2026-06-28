<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\BreedService;
use App\Services\PetService;
use App\Services\SpecieService;
use CodeIgniter\HTTP\ResponseInterface;

class PetController extends BaseController
{
    private PetService $petService;
    private SpecieService $specieService;

    public function __construct() {
        $this->petService = service('pet');
        $this->specieService = service('specie');
    }

    public function index()
    {
        // todo: listar as pets
    }

    public function create() {
        $result = $this->specieService->getAllSpecies();

        if (!$result['success']) {
            return redirect()->back()->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('pets/create', [
            'title' => 'Novo Pet',
            'species' => $result['species'],
        ]);
    }

    public function store() {
        $result = $this->petService->createPet([
            'breed_id' => $this->request->getPost('breed_id'),
            'name' => $this->request->getPost('name'),
            'sex' => $this->request->getPost('sex'),
            'birth_date' => $this->request->getPost('birth_date'),
            'weight' => $this->request->getPost('weight'),
            'notes' => $this->request->getPost('notes'),
            'owner_name' => $this->request->getPost('owner_name'),
            'owner_phone' => $this->request->getPost('owner_phone')
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('pets')->with('message', $result['message']);
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
