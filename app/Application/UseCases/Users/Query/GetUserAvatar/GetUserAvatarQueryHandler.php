<?php

namespace App\Application\UseCases\Users\Query\GetUserAvatar;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Query\GetFile\GetFileQuery;
use App\Application\UseCases\Files\Query\GetFile\GetFileQueryHandler;
use App\Core\Domain\Entities\User\IUserRepository;

class GetUserAvatarQueryHandler
{
    private IUserRepository $userRepository;
    private GetFileQueryHandler $getFileQueryHandler;

    public function __construct(IUserRepository $userRepository, GetFileQueryHandler $getFileQueryHandler)
    {
        $this->userRepository = $userRepository;
        $this->getFileQueryHandler = $getFileQueryHandler;
    }


    public function handle(GetUserAvatarQuery $query): string|ErrorDto
    {
        if (!$this->userRepository->tryFindById($query->userId)) {
            return new ErrorDto(['1' => "User with id $query->userId not found"], 404);
        };

        $user = $this->userRepository->findById($query->userId);

        if ($user->getAvatarId() === null) {
            return new ErrorDto(['1' => "User avatar not found"], 404);
        }

        return $this->getFileQueryHandler->handle(new GetFileQuery($user->getAvatarId()));
    }
}
