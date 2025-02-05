<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Comment\Command\CreateComment\CreateCommentCommand;
use App\Application\UseCases\Comment\Command\CreateComment\CreateCommentCommandHandler;
use App\Application\UseCases\Comment\Command\DeleteComment\DeleteCommentCommand;
use App\Application\UseCases\Comment\Command\DeleteComment\DeleteCommentCommandHandler;
use App\Application\UseCases\Comment\Command\UpdateComment\UpdateCommentCommand;
use App\Application\UseCases\Comment\Command\UpdateComment\UpdateCommentCommandHandler;
use App\Application\UseCases\Comment\Query\GetCommentById\GetCommentByIdQuery;
use App\Application\UseCases\Comment\Query\GetCommentById\GetCommentByIdQueryHandler;
use App\Application\UseCases\Comment\Query\GetCommentsByCompanyId\GetCommentsByCompanyIdQuery;
use App\Application\UseCases\Comment\Query\GetCommentsByCompanyId\GetCommentsByCompanyIdQueryHandler;
use App\Presentation\Http\Requests\Comment\CreateCommentRequest;
use App\Presentation\Http\Requests\Comment\UpdateCommentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CommentsController extends Controller
{
    public function __construct(
        private readonly GetCommentByIdQueryHandler $getCommentByIdQueryHandler,
        private readonly GetCommentsByCompanyIdQueryHandler $getCommentsByCompanyIdQueryHandler,
        private readonly CreateCommentCommandHandler $createCommentCommandHandler,
        private readonly UpdateCommentCommandHandler $updateCommentCommandHandler,
        private readonly DeleteCommentCommandHandler $deleteCommentCommandHandler,
    )
    {
    }

    public function get(int $id): JsonResponse
    {
        $result = $this->getCommentByIdQueryHandler->handle(new GetCommentByIdQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Ok', 'data' => $result]);
    }

    public function getCommentsByCompanyId(int $companyId): JsonResponse
    {
        $result = $this->getCommentsByCompanyIdQueryHandler->handle(new GetCommentsByCompanyIdQuery($companyId));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Ok', 'data' => $result]);
    }

    public function create(CreateCommentRequest $request): JsonResponse
    {
        $createCommentDto = $request->toDto();

        $result = $this->createCommentCommandHandler->handle(New CreateCommentCommand($createCommentDto));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Comment created successfully!', 'data' => ['id' => $result]]);
    }

    public function update(UpdateCommentRequest $request, int $id): JsonResponse
    {
        $updateCommentDto = $request->toDto();

        $result = $this->updateCommentCommandHandler->handle(New UpdateCommentCommand($id, $updateCommentDto));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Comment updated successfully!', 'data' => ['id' => $id]]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->deleteCommentCommandHandler->handle(New DeleteCommentCommand($id));

        if ($result instanceof ErrorDto) {
            return response()->json(['status' => $result->getCode(), 'message' => 'Error', 'errors' => $result->getErrorList()]);
        }

        return response()->json(['status' => 200, 'message' => 'Comment deleted successfully!', 'data' => ['id' => $id]]);
    }
}
