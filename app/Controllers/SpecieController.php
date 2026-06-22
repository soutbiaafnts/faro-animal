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
            'pager' => $species['pager'],
        ]);
    }

    public function create() {
        return view('species/create', ['title' => 'Nova Espécie']);
    }

    public function store() {
        // todo: inserir nova espécie no bd
    }

    public function edit(int $id) {
        // todo: view specie/edit
    }

    public function update(int $id) {
        // todo: atualizar espécie do bd de acordo com o id
    }

    public function delete(int $id) {
        // todo: deletar espécie do bd de acordo com o id
    }
}
