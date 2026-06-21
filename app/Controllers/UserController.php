<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserService;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected UserService $userService;

    public function __construct() {
        $this->userService = service('user');
    }

    public function index()
    {
        // todo: meu perfil
        $userId = session()->get('user_id');

        $user = $this->userService->getUserById($userId);

        if ($user['success'] === false) {
            return redirect()->route('users')->with('error', $user['message']);
        }

        return view('users/me', [
            'user' => $user['data'],
            'title' => 'Meu perfil',
        ]);
    }
    
    public function create()
    {
        // todo: view user/create
    }

    public function store()
    {
        // todo: inserir novo usuário no bd
    }
   
    public function edit(int $id)
    {
        // todo: view user/edit
    }
   
    public function update(int $id)
    {
        // todo: atualizar usuário do bd de acordo com o id
    }

    public function delete(int $id)
    {
        // todo: deletar usuário do bd de acordo com o id
    }
}
