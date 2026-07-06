<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SpecieService;

class SpecieController extends BaseController
{
    protected SpecieService $specieService;

    public function __construct()
    {
        $this->specieService = service('specie');
    }

    public function index()
    {
        $result = $this->specieService->getAllSpecies();

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('species/list', [
            'title' => 'Espécies',
            'species' => $result['data'],
        ]);
    }

    public function create()
    {
        return view('species/create', ['title' => 'Nova Espécie']);
    }

    public function store()
    {
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

        return redirect()->route('species')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function edit(int $id)
    {
        $specie = $this->specieService->getSpecieById($id);

        if (!$specie['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $specie['message'])
                ->with('invalidArgs', $specie['invalidArgs'])
                ->with('errors', $specie['errors']);
        }

        return view('species/edit', [
            'title' => 'Editar Espécie',
            'specie' => $specie['data'],
        ]);
    }

    public function update(int $id)
    {
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

        return redirect()->route('species')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function delete(int $id)
    {
        $result = $this->specieService->deleteSpecie($id);

        if (!$result['success']) {
            return redirect()->back()
                ->with('message', $result['message'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('species')->with('success', $result['success'])->with('message', $result['message']);
    }
}
