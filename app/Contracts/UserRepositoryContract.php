<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function create(array $data): User;
}
