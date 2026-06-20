<?php

namespace App\Services;

use App\Models\UserModel;

class UserService {
    protected UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
}