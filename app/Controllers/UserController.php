<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\UserService;

class UserController extends BaseController
{
    protected UserService $userService;

    public function __construct()
    {
        $this->userService = service('user');
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $result = $this->userService->getUserById($userId);

        if ($result['success'] === false) {
            return redirect()->route('users')
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return view('users/me', [
            'user' => $result['data'],
            'title' => 'Meu perfil',
        ]);
    }

    public function create()
    {
        return view('users/create', ['title' => 'Cadastre-se']);
    }

    public function store()
    {
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
                return redirect()->back()
                    ->withInput()
                    ->with('message', $result['message'])
                    ->with('invalidArgs', $result['invalidArgs'])
                    ->with('errors', $result['errors']);
            }

            return redirect()->route('login')->with('success', $result['success'])->with('message', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('message', 'Erro:')->with('errors', $e->getMessage());
        }
    }

    public function update()
    {
        $userId = session()->get('user_id');

        $result = $this->userService->updateProfile($userId, [
            'name' => $this->request->getPost('name')
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('me')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function updatePassword()
    {
        $userId = session()->get('user_id');

        $result = $this->userService->updatePassword($userId, [
            'currentPassword' => $this->request->getPost('currentPassword'),
            'newPassword' => $this->request->getPost('newPassword'),
            'confirmNewPassword' => $this->request->getPost('confirmNewPassword'),
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        return redirect()->route('me')->with('success', $result['success'])->with('message', $result['message']);
    }

    public function delete()
    {
        $userId = session()->get('user_id');

        $result = $this->userService->deleteUser($userId);

        if (!$result['success']) {
            return redirect()->back()
                ->with('message', $result['message'])
                ->with('invalidArgs', $result['invalidArgs'])
                ->with('errors', $result['errors']);
        }

        session()->destroy();

        return redirect()->route('login')->with('success', $result['success'])->with('message', $result['message']);
    }
}
