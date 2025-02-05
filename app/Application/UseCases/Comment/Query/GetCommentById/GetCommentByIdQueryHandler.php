<?php

namespace App\Application\UseCases\Comment\Query\GetCommentById;

use App\Application\DTOs\Comment\CommentDto;
use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Comment\ICommentRepository;
use App\Core\Domain\Exception\CustomException;

class GetCommentByIdQueryHandler
{
    private ICommentRepository $commentRepository;
    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(GetCommentByIdQuery $query): CommentDto|ErrorDto {
        if (!$this->commentRepository->tryFindById($query->id)) {
            return new ErrorDto(['1' => "Comment with id $query->id not found"], 404);
        };

        try {
            $comment = $this->commentRepository->findById($query->id);
        }
        catch (CustomException $e) {
            return new ErrorDto(['1' => "Invalid comment with $query->id keys invalid"], 400);
        }
        catch (\Exception $e) {
            return new ErrorDto(['1' => "Comment with id $query->id not found"], 500);
        }


        return new CommentDto(
            $comment->getCommentId(),
            $comment->getUserId(),
            $comment->getCompanyId(),
            $comment->getContent(),
            $comment->getRating(),
        );
    }
}
