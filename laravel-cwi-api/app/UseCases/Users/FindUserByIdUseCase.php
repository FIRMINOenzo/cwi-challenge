<?php

namespace App\UseCases\Users;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\UseCases\UseCaseInterface;
use App\Exceptions\User\UserNotFoundException;
use App\Models\User;

/**
 * @implements UseCaseInterface<int, User>
 */
class FindUserByIdUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public function handle(mixed $input = null): User
    {
        $id = (int) $input;

        $user = $this->repository->findById($id);

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
