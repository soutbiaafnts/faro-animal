<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SpecieService;
use CodeIgniter\HTTP\ResponseInterface;

class SpecieController extends BaseController
{
    protected SpecieService $specieService;

    public function __construct() {
        $this->specieService = service('specie');
    }

    public function index()
    {
        $species = $this->specieService->getAllSpecies();

        if (!$species['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $species['message'])
                ->with('invalidArgs', $species['invalidArgs'])
                ->with('errors', $species['errors']);
        }

        return view('species/list', [
            'title' => 'Espécies',
            'message' => $species['message'],
            'species' => $species['species'],
        ]);
    }

    public function create() {
        return view('species/create', ['title' => 'Nova Espécie']);
    }

    public function store() {
        try {
            $result = $this->specieService->createSpecie([
                'name' => $this->request->getPost('name'),
            ]);

            if (!$result['success']) {
                return redirect()->back()
                    ->withInput()
                    ->with('message', $result['message'])
                    ->with('invalidArgs', $result['invalidArgs'])
                    ->with('errors', $result['errors']);
            }

            return redirect()->route('species')->with('message', $result['message']);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('message', 'Erro:')->with('errors', $e->getMessage());
        }
    }

    public function edit(int $id) {
        $specie = $this->specieService->getSpecieById($id);

        // ? here are 2 if doing the same thing FIX IT
        if (!$specie['success']) {
            if (!$specie['success']) {
                return redirect()->back()
                    ->withInput()
                    ->with('message', $specie['message'])
                    ->with('invalidArgs', $specie['invalidArgs'])
                    ->with('errors', $specie['errors']);
            }
        }

        return view('species/edit', [
            'title' => 'Editar Espécie',
            'specie' => $specie['specie'],
        ]);
    }

    public function update(int $id) {
        try {
            $result = $this->specieService->updateSpecie($id, [
                'name' => $this->request->getPost('name')
            ]);

            if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('species')->with('message', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('message', 'Erro:')->with('errors', $e->getMessage());
        }
    }

    public function delete(int $id) {
        $result = $this->specieService->deleteSpecie($id);

        if (!$result['success']) {
            return redirect()->back()
                ->with('message', $result['message'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('species')->with('message', $result['message']);
    }
}
