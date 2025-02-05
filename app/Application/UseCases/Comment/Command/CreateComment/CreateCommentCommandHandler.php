<?php

namespace App\Application\UseCases\Comment\Command\CreateComment;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Comment\Comment;
use App\Core\Domain\Entities\Comment\ICommentRepository;

class CreateCommentCommandHandler
{
    private ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(CreateCommentCommand $command): int|ErrorDto {
        $dto = $command->dto;

        $comment = new Comment($dto->userId, $dto->companyId, $dto->content, $dto->rating);

        return $this->commentRepository->create($comment);
    }
}
