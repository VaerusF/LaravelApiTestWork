<?php

namespace App\Application\UseCases\Comment\Command\DeleteComment;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Comment\ICommentRepository;

class DeleteCommentCommandHandler
{
    private ICommentRepository $commentRepository;
    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(DeleteCommentCommand $command): bool|ErrorDto
    {
        if (!$this->commentRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "Comment with id $command->id not found"], 404);
        };

        $this->commentRepository->delete($command->id);

        return true;
    }
}
