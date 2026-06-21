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

    public function index() {
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
    
    public function create() {
        return view('users/create', ['title' => 'Cadastre-se']);
    }

    public function store() {
        try {
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirmPassword');

            if ($password != $confirmPassword) {
                return redirect()->back()->withInput()->with('invalidArgs', ['confirmPassword' => 'As senhas não coincidem.']);
            }

            $result = $this->userService->createUser([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ]);

            if (!$result['success']) {
                return redirect()->back()->withInput()->with('invalidArgs', $result['invalidArgs']);
            }

            return redirect()->route('login')->with('success', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }
   
    public function edit(int $id) {
        // todo: view user/edit
    }
   
    public function update(int $id) {
        // todo: atualizar usuário do bd de acordo com o id
    }

    public function delete(int $id) {
        // todo: deletar usuário do bd de acordo com o id
    }
}
