<?php

namespace App\UseCases\Users;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\UseCases\UseCaseInterface;
use App\Exceptions\User\UserEmailAlreadyInUseException;
use App\Models\User;
use App\UseCases\Users\Input\UpdateUserInput;
use InvalidArgumentException;

/**
 * @implements UseCaseInterface<UpdateUserInput, User>
 */
class UpdateUserUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly FindUserByIdUseCase $findUserById,
    ) {
    }

    public function handle(mixed $input = null): User
    {
        if (! $input instanceof UpdateUserInput) {
            throw new InvalidArgumentException('Expected instance of UpdateUserInput.');
        }

        $user = $this->findUserById->handle($input->id);

        if (isset($input->payload['email']) && $this->repository->emailInUseByAnotherUser($input->payload['email'], $user->id)) {
            throw new UserEmailAlreadyInUseException();
        }

        return $this->repository->update($user, $input->payload);
    }
}
