<?php

namespace App\Application\UseCases\Users\Command\DeleteUserAvatar;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommand;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommandHandler;
use App\Core\Domain\Entities\User\IUserRepository;

class DeleteUserAvatarCommandHandler
{
    private IUserRepository $userRepository;
    private DeleteFileCommandHandler $deleteFileCommandHandler;
    public function __construct(IUserRepository $userRepository, DeleteFileCommandHandler $deleteFileCommandHandler)
    {
        $this->userRepository = $userRepository;
        $this->deleteFileCommandHandler = $deleteFileCommandHandler;
    }

    public function handle(DeleteUserAvatarCommand $command): bool|ErrorDto
    {
        if (!$this->userRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "User with id $command->id not found"], 404);
        };

        $user = $this->userRepository->findById($command->id);

        if ($user->getAvatarId() !== null) {
            $deleteResult = $this->deleteFileCommandHandler->handle(new DeleteFileCommand($user->getAvatarId()));

            if ($deleteResult instanceof ErrorDto) {
                return $deleteResult;
            }

            $this->userRepository->deleteAvatar($user->getId());
        }

        return true;
    }
}
