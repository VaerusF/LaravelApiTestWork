<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Core\Domain\Entities\User\IUserRepository;
use App\Core\Domain\Entities\User\User;
use App\Core\Domain\Exception\NotFound\UserNotFoundException;
use App\Infrastructure\Persistence\Models\UserModel;

class UserRepository implements IUserRepository
{

    public function create(User $user): int
    {
        $userModel = new UserModel();

        $userModel->firstname = $user->getFirstname();
        $userModel->lastname = $user->getLastname();
        $userModel->phone = $user->getPhone();
        $userModel->avatar_id = $user->getAvatarId();

        $userModel->save();

        return $userModel->user_id;
    }

    public function tryFindById(int $id): bool {
        $userModel = UserModel::find($id);

        if ($userModel === null) {
            return false;
        }

        return true;
    }
    /**
     * @throws UserNotFoundException
     */
    public function findById(int $id): User
    {
        $userModel = UserModel::findOr($id, function () {
            throw new UserNotFoundException();
        });

        $user = new User($userModel->firstname, $userModel->lastname, $userModel->phone, $userModel->avatar_id);
        $user->setId($userModel->user_id);

        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(User $userNewState): bool
    {
        $userOld = UserModel::findOr($userNewState->getId(), function () {
            throw new UserNotFoundException();
        });

        $userOld->firstname = $userNewState->getFirstname();
        $userOld->lastname = $userNewState->getLastname();
        $userOld->phone = $userNewState->getPhone();

        if ($userNewState->getAvatarId() !== null) {
            $userOld->avatar_id = $userNewState->getAvatarId();
        }

        $userOld->save();

        return true;
    }

    /**
     * @throws UserNotFoundException
     */
    public function deleteAvatar(int $userId): bool
    {
        $userOld = UserModel::findOr($userId, function () {
            throw new UserNotFoundException();
        });

        $userOld->avatar_id = null;

        $userOld->save();

        return true;
    }

    public function delete(int $id): void
    {
        if (!$this->tryFindById($id)) {
            throw new UserNotFoundException();
        };

        UserModel::destroy($id);
    }
}
