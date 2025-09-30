<?php

namespace App\UseCases\Users;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\UseCases\UseCaseInterface;
use App\Exceptions\User\UserEmailAlreadyInUseException;
use App\Models\User;
use App\UseCases\Users\Input\StoreUserInput;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use InvalidArgumentException;

/**
 * @implements UseCaseInterface<StoreUserInput, User>
 */
class StoreUserUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public function handle(mixed $input = null): User
    {
        if (! $input instanceof StoreUserInput) {
            throw new InvalidArgumentException('Expected instance of StoreUserInput.');
        }

        $payload = $input->payload;

        if ($this->repository->findByEmail($payload['email'])) {
            throw new UserEmailAlreadyInUseException();
        }

        $user = $this->repository->create($payload);

        Event::dispatch(new Registered($user));

        return $user;
    }
}
