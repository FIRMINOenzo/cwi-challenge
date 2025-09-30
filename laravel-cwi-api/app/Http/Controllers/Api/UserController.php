<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\UseCases\Users\DeleteUserUseCase;
use App\UseCases\Users\FindAllUsersUseCase;
use App\UseCases\Users\FindUserByIdUseCase;
use App\UseCases\Users\StoreUserUseCase;
use App\UseCases\Users\UpdateUserUseCase;
use App\UseCases\Users\Input\UpdateUserInput;
use App\UseCases\Users\Input\StoreUserInput;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly FindAllUsersUseCase $findAllUsers,
        private readonly StoreUserUseCase $storeUser,
        private readonly FindUserByIdUseCase $findUserById,
        private readonly UpdateUserUseCase $updateUser,
        private readonly DeleteUserUseCase $deleteUser,
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->findAllUsers->handle();

        return response()->json(UserResource::collection($users), Response::HTTP_OK);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->storeUser->handle(StoreUserInput::from($request->validated()));

        return response()->json(UserResource::make($user), Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->findUserById->handle((int) $id);

        return response()->json(UserResource::make($user), Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->updateUser->handle(UpdateUserInput::from((int) $id, $request->validated()));

        return response()->json(UserResource::make($user), Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteUser->handle((int) $id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
