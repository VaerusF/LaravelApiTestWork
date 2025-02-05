<?php

namespace App\Application\UseCases\Users\Command\CreateUser;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\UploadUserAvatar\UploadUserAvatarCommand;
use App\Application\UseCases\Files\Command\UploadUserAvatar\UploadUserAvatarCommandHandler;
use App\Core\Domain\Entities\User\IUserRepository;
use App\Core\Domain\Entities\User\User;

class CreateUserCommandHandler
{
    private IUserRepository $userRepository;
    private UploadUserAvatarCommandHandler $uploadUserAvatarCommand;

    public function __construct(IUserRepository $userRepository, UploadUserAvatarCommandHandler $uploadUserAvatarCommand)
    {
        $this->userRepository = $userRepository;
        $this->uploadUserAvatarCommand = $uploadUserAvatarCommand;
    }

    public function handle(CreateUserCommand $command): int|ErrorDto
    {
        $dto = $command->dto;

        $fileId = $this->uploadUserAvatarCommand->handle(new UploadUserAvatarCommand($dto->avatar));

        if ($fileId instanceof ErrorDto) {
            return $fileId;
        }

        $user = new User($dto->firstname, $dto->lastname, $dto->phone, $fileId);

        return $this->userRepository->create($user);
    }
}
