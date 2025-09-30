<?php

namespace App\UseCases\Users;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\UseCases\UseCaseInterface;
use App\Models\User;
use InvalidArgumentException;

/**
 * @implements UseCaseInterface<int, User>
 */
class DeleteUserUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly FindUserByIdUseCase $findUserById,
    ) {
    }

    public function handle(mixed $input = null): User
    {
        if (! is_int($input)) {
            throw new InvalidArgumentException('Expected integer ID for DeleteUserUseCase.');
        }

        $user = $this->findUserById->handle($input);

        $this->repository->delete($user);

        return $user;
    }
}
