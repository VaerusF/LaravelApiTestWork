<?php

namespace App\Application\UseCases\Users\Command\DeleteUser;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Users\Command\DeleteUserAvatar\DeleteUserAvatarCommand;
use App\Application\UseCases\Users\Command\DeleteUserAvatar\DeleteUserAvatarCommandHandler;
use App\Core\Domain\Entities\User\IUserRepository;

class DeleteUserCommandHandler
{
    private IUserRepository $userRepository;
    private DeleteUserAvatarCommandHandler $deleteUserAvatarCommandHandler;

    public function __construct(IUserRepository $userRepository, DeleteUserAvatarCommandHandler $deleteUserAvatarCommandHandler)
    {
        $this->userRepository = $userRepository;
        $this->deleteUserAvatarCommandHandler = $deleteUserAvatarCommandHandler;
    }

    public function handle(DeleteUserCommand $command): bool|ErrorDto
    {
        if (!$this->userRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "User with id $command->id not found"], 404);
        };

        $this->deleteUserAvatarCommandHandler->handle(new DeleteUserAvatarCommand($command->id));

        $this->userRepository->delete($command->id);

        return true;
    }
}
