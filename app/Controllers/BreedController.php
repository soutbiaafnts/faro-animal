<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\BreedService;
use App\Services\SpecieService;

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
            'breeds' => $result['data'],
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
            'species' => $result['data'],
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

        return redirect()->route('breeds')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function edit(int $id)
    {
        $breed = $this->breedService->getBreedById($id);

        if (!$breed['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $breed['message'])
                ->with('invalidArgs', $breed['invalidArgs'])
                ->with('errors', $breed['errors']);
        }

        return view('breeds/edit', [
            'title' => 'Editar Raça',
            'breed' => $breed['data'],
        ]);
    }

    public function update(int $id)
    {
        $result = $this->breedService->updateBreed($id, [
            'name' => $this->request->getPost('name'),
            'species_id' => $this->request->getPost('species_id'),
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('breeds')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function delete(int $id)
    {
        $result = $this->breedService->deleteBreed($id);

        if (!$result['success']) {
            return redirect()->back()
                ->with('message', $result['message'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('breeds')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function getBySpecie(int $specieId) {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setBody('Acesso não autorizado.');
        }

        $result = $this->breedService->getBreedsBySpecie($specieId);

        return $this->response->setJSON($result);
    }
}
