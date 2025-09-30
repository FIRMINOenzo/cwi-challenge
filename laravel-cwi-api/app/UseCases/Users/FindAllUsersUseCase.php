<?php

namespace App\UseCases\Users;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\UseCases\UseCaseInterface;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * @implements UseCaseInterface<null, Collection<int, User>>
 */
class FindAllUsersUseCase implements UseCaseInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    /**
     */
    public function handle(mixed $input = null): Collection
    {
        return $this->repository->all();
    }
}
