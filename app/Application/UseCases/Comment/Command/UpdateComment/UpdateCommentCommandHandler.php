<?php

namespace App\Application\UseCases\Comment\Command\UpdateComment;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Comment\Comment;
use App\Core\Domain\Entities\Comment\ICommentRepository;

class UpdateCommentCommandHandler
{
    private ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(UpdateCommentCommand $command) : bool|ErrorDto {
        if (!$this->commentRepository->tryFindById($command->commentId)) {
            return new ErrorDto(['1' => 'Company not found'], 404);
        }

        $dto = $command->dto;

        $commentNewState = new Comment($dto->userId, $dto->companyId, $dto->content, $dto->rating);
        $commentNewState->setCommentId($command->commentId);

        return $this->commentRepository->update($commentNewState);
    }
}
