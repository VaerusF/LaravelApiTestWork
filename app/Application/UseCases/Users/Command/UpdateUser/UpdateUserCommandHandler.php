<?php

namespace App\Application\UseCases\Users\Command\UpdateUser;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommand;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommandHandler;
use App\Application\UseCases\Files\Command\UploadUserAvatar\UploadUserAvatarCommand;
use App\Application\UseCases\Files\Command\UploadUserAvatar\UploadUserAvatarCommandHandler;
use App\Core\Domain\Entities\User\IUserRepository;
use App\Core\Domain\Entities\User\User;

class UpdateUserCommandHandler
{
    private IUserRepository $userRepository;
    private UploadUserAvatarCommandHandler $uploadUserAvatarCommand;
    private DeleteFileCommandHandler $deleteFileCommandHandler;

    public function __construct(
        IUserRepository $userRepository,
        UploadUserAvatarCommandHandler $uploadUserAvatarCommand,
        DeleteFileCommandHandler $deleteFileCommandHandler

    )
    {
        $this->userRepository = $userRepository;
        $this->uploadUserAvatarCommand = $uploadUserAvatarCommand;
        $this->deleteFileCommandHandler = $deleteFileCommandHandler;
    }

    public function handle(UpdateUserCommand $command): bool|ErrorDto
    {
        if (!$this->userRepository->tryFindById($command->userId)) {
            return new ErrorDto(['1' => 'User not found'], 404);
        };

        $userOldState = $this->userRepository->findById($command->userId);


        $dto = $command->dto;

        $fileId = null;

        if ($dto->avatar !== null) {
            if ($userOldState->getAvatarId() !== null) {
                $deleteResult = $this->deleteFileCommandHandler->handle(new DeleteFileCommand($userOldState->getAvatarId()));

                if ($deleteResult instanceof ErrorDto) {
                    return new $deleteResult;
                }
            }

            $fileId = $this->uploadUserAvatarCommand->handle(new UploadUserAvatarCommand($dto->avatar));

            if ($fileId instanceof ErrorDto) {
                return $fileId;
            }
        }

        $userNewState = new User($dto->firstname, $dto->lastname, $dto->phone, $fileId);
        $userNewState->setId($command->userId);
        return $this->userRepository->update($userNewState);
    }
}
