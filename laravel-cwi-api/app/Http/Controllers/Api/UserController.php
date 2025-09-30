<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        $validRequest = $request->validated();

        $user = User::create($validRequest);

        return UserResource::make($user);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        return UserResource::make($user);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $user->update($request->validated());

        return UserResource::make($user);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $user->delete();

        return UserResource::make($user);
    }
}
