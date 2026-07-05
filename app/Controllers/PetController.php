<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\PetService;
use App\Services\SpecieService;

class PetController extends BaseController
{
    private PetService $petService;
    private SpecieService $specieService;

    public function __construct() {
        $this->petService = service('pet');
        $this->specieService = service('specie');
    }

    public function index() {
        $result = $this->petService->getAllPets();

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('pets/list', [
            'title' => 'Pets',
            'message' => $result['message'],
            'pets' => $result['pets'],
        ]);
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
        $result = $this->petService->getPetById($id);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('pets/edit', [
            'title' => 'Editar Pet',
            'pet' => $result['pet'],
        ]);
    }

    public function update(int $id)
    {
        $result = $this->petService->updatePet($id, [
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

    public function delete(int $id) {
        $result = $this->petService->deletePet($id);

        if (!$result['success']) {
            return redirect()->back()
                ->with('message', $result['message'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('pets')->with('message', $result['message']);
    }
}
