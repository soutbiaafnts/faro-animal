<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\BreedService;
use App\Services\SpecieService;
use CodeIgniter\HTTP\ResponseInterface;

class BreedController extends BaseController
{
    private BreedService $breedService;
    private SpecieService $specieService;

    public function __construct() {
        $this->breedService = service('breed');
        $this->specieService = service('specie');
    }

    public function index() {
        $result = $this->breedService->getAllBreeds();

        if (!$result['success']) {
            return redirect()->back()->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('breeds/list', [
            'title' => 'Raças',
            'message' => $result['message'],
            'breeds' => $result['breeds'],
            'pager' => $result['pager'],
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

        return view('breeds/create', [
            'title' => 'Nova Raça',
            'species' => $result['species'],
        ]);
    }

    public function store()
    {
        $result = $this->breedService->createBreed([
            'species_id' => $this->request->getPost('species_id'),
            'name' => $this->request->getPost('name'),
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('breeds')->with('message', $result['message']);
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
