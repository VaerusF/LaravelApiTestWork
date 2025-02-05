<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Users\Command\CreateUser\CreateUserCommand;
use App\Application\UseCases\Users\Command\CreateUser\CreateUserCommandHandler;
use App\Application\UseCases\Users\Command\DeleteUser\DeleteUserCommand;
use App\Application\UseCases\Users\Command\DeleteUser\DeleteUserCommandHandler;
use App\Application\UseCases\Users\Command\DeleteUserAvatar\DeleteUserAvatarCommand;
use App\Application\UseCases\Users\Command\DeleteUserAvatar\DeleteUserAvatarCommandHandler;
use App\Application\UseCases\Users\Command\UpdateUser\UpdateUserCommand;
use App\Application\UseCases\Users\Command\UpdateUser\UpdateUserCommandHandler;
use App\Application\UseCases\Users\Query\GetUserAvatar\GetUserAvatarQuery;
use App\Application\UseCases\Users\Query\GetUserAvatar\GetUserAvatarQueryHandler;
use App\Application\UseCases\Users\Query\GetUserById\GetUserByIdQuery;
use App\Application\UseCases\Users\Query\GetUserById\GetUserByIdQueryHandler;
use App\Presentation\Http\Requests\User\CreateUserRequest;
use App\Presentation\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UsersController extends Controller
{
    public function __construct(
        private readonly GetUserByIdQueryHandler $getUserByIdQueryHandler,
        private readonly GetUserAvatarQueryHandler $getUserAvatarQueryHandler,
        private readonly CreateUserCommandHandler $createUserCommandHandler,
        private readonly UpdateUserCommandHandler $updateUserCommandHandler,
        private readonly DeleteUserAvatarCommandHandler $deleteUserAvatarCommandHandler,
        private readonly DeleteUserCommandHandler $deleteUserCommandHandler,
    ) {}

    public function get(int $id): JsonResponse
    {
        $result = $this->getUserByIdQueryHandler->handle(new GetUserByIdQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200,'message' => 'Ok', 'data' => $result]);
    }

    public function getUserAvatar(int $id): StreamedResponse|JsonResponse
    {
        $result = $this->getUserAvatarQueryHandler->handle(new GetUserAvatarQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()]
            );
        }

        return Storage::response($result);
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $createUserDto = $request->toDto();

        $result = $this->createUserCommandHandler->handle(New CreateUserCommand($createUserDto));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200,'message' => 'User created successfully!', 'data' => ['id' => $result]]);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $updateUserDto = $request->toDto();

        $result = $this->updateUserCommandHandler->handle(New UpdateUserCommand($id, $updateUserDto));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'User updated successfully!', 'data' => ['id' => $id]]);
    }

    public function deleteUserAvatar(int $id): JsonResponse
    {
        $result = $this->deleteUserAvatarCommandHandler->handle(new DeleteUserAvatarCommand($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200,'message' => 'User avatar deleted successfully!', 'data' => ['id' => $id]]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->deleteUserCommandHandler->handle(New DeleteUserCommand($id));

        if ($result instanceof ErrorDto) {
            return response()->json(['status' => $result->getCode(), 'message' => 'Error', 'errors' => $result->getErrorList()]);
        }

        return response()->json(['status' => 200, 'message' => 'User deleted successfully!', 'data' => ['id' => $id]]);
    }
}
