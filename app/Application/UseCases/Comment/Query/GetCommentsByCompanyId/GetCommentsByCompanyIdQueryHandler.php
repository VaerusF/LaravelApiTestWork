<?php

namespace App\Application\UseCases\Comment\Query\GetCommentsByCompanyId;

use App\Application\DTOs\Comment\CommentDto;
use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Comment\Comment;
use App\Core\Domain\Entities\Comment\ICommentRepository;

class GetCommentsByCompanyIdQueryHandler
{
    private ICommentRepository $commentRepository;
    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return CommentDto[]|ErrorDto
     */
    public function handle(GetCommentsByCompanyIdQuery $query): array|ErrorDto {
        $comments = $this->commentRepository->findByCompanyId($query->companyId);

        return collect($comments)->map(function (Comment $comment) {
            return new CommentDto(
                $comment->getCommentId(),
                $comment->getUserId(),
                $comment->getCompanyId(),
                $comment->getContent(),
                $comment->getRating(),
            );
        })->toArray();
    }
}
