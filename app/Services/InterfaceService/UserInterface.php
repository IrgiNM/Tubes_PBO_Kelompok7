<?php

namespace App\Services\InterfaceService;

use App\Models\User;

interface UserInterface
{
    public function registerUser(array $data): User;
}
