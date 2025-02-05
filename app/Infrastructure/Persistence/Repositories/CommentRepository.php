<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Core\Domain\Entities\Comment\Comment;
use App\Core\Domain\Entities\Comment\ICommentRepository;
use App\Core\Domain\Exception\NotFound\CommentNotFoundException;
use App\Core\Domain\Exception\NotFound\CompanyNotFoundException;
use App\Core\Domain\Exception\NotFound\UserNotFoundException;
use App\Infrastructure\Persistence\Models\CommentModel;

class CommentRepository implements ICommentRepository
{

    public function create(Comment $comment): int
    {
        $commentModel = new CommentModel();

        $commentModel->user_id = $comment->getUserId();
        $commentModel->company_id = $comment->getCompanyId();
        $commentModel->content = $comment->getContent();
        $commentModel->rating = $comment->getRating();

        $commentModel->save();

        return $commentModel->comment_id;
    }

    public function tryFindById(int $id): bool
    {
        $commentModel = CommentModel::find($id);

        if ($commentModel === null) {
            return false;
        }

        return true;
    }

    /**
     * @throws CommentNotFoundException
     * @throws UserNotFoundException
     * @throws CompanyNotFoundException
     */
    public function findById(int $id): Comment
    {
        $commentModel = CommentModel::findOr($id, function () {
            throw new CommentNotFoundException();
        });

        if ($commentModel->user_id === null) {
            throw new UserNotFoundException();
        }

        if ($commentModel->company_id === null) {
            throw new CompanyNotFoundException();
        }


        $company = new Comment(
            $commentModel->user_id,
            $commentModel->company_id,
            $commentModel->content,
            $commentModel->rating
        );
        $company->setCommentId($commentModel->comment_id);

        return $company;
    }

    /**
     * @return Comment[]
     */
    public function findByCompanyId(int $companyId): array
    {
        return CommentModel::where('company_id', $companyId)
            ->get()
            ->reject(function (CommentModel $commentModel) {
                return $commentModel->user_id === null || $commentModel->company_id === null;
            })
            ->map(function (CommentModel $commentModel) {
                $company = new Comment(
                    $commentModel->user_id,
                    $commentModel->company_id,
                    $commentModel->content,
                    $commentModel->rating
                );
                $company->setCommentId($commentModel->comment_id);

                return $company;
            })->toArray();
    }

    /**
     * @throws CommentNotFoundException
     */
    public function update(Comment $commentNewState): bool
    {
        $commentOld = CommentModel::findOr($commentNewState->getCommentId(), function () {
            throw new CommentNotFoundException();
        });

        $commentOld->user_id = $commentNewState->getUserId();
        $commentOld->company_id = $commentNewState->getCompanyId();
        $commentOld->content = $commentNewState->getContent();
        $commentOld->rating = $commentNewState->getRating();

        $commentOld->save();

        return true;
    }

    /**
     * @throws CommentNotFoundException
     */
    public function delete(int $id): void
    {
        if (!$this->tryFindById($id)) {
            throw new CommentNotFoundException();
        };

        CommentModel::destroy($id);
    }
}
