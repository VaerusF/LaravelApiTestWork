<?php

namespace App\Application\UseCases\Users\Query\GetUserById;

use App\Application\DTOs\ErrorDto;
use App\Application\DTOs\Users\UserDto;
use App\Core\Domain\Entities\User\IUserRepository;

class GetUserByIdQueryHandler
{
    private IUserRepository $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(GetUserByIdQuery $query): UserDto|ErrorDto {
        if (!$this->userRepository->tryFindById($query->id)) {
            return new ErrorDto(['1' => "User with id $query->id not found"], 404);
        };

        $user = $this->userRepository->findById($query->id);

        return new UserDto(
            $user->getId(),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getPhone(),
            $user->getAvatarId()
        );
    }
}
