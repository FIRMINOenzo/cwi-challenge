<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return Collection<int, User>
     */
    public function all(): Collection;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function emailInUseByAnotherUser(string $email, int $exceptId): bool;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function delete(User $user): void;
}

