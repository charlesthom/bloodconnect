<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findById(int $id): User;
    public function update(array $data): bool;
    public function delete(int $id): int;
}
