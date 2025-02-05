<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Company\Command\CreateCompany\CreateCompanyCommand;
use App\Application\UseCases\Company\Command\CreateCompany\CreateCompanyCommandHandler;
use App\Application\UseCases\Company\Command\DeleteCompany\DeleteCompanyCommand;
use App\Application\UseCases\Company\Command\DeleteCompany\DeleteCompanyCommandHandler;
use App\Application\UseCases\Company\Command\DeleteCompanyLogo\DeleteCompanyLogoCommand;
use App\Application\UseCases\Company\Command\DeleteCompanyLogo\DeleteCompanyLogoCommandHandler;
use App\Application\UseCases\Company\Command\UpdateCompany\UpdateCompanyCommand;
use App\Application\UseCases\Company\Command\UpdateCompany\UpdateCompanyCommandHandler;
use App\Application\UseCases\Company\Query\GetCompanyById\GetCompanyByIdQuery;
use App\Application\UseCases\Company\Query\GetCompanyById\GetCompanyByIdQueryHandler;
use App\Application\UseCases\Company\Query\GetCompanyLogo\GetCompanyLogoQuery;
use App\Application\UseCases\Company\Query\GetCompanyLogo\GetCompanyLogoQueryHandler;
use App\Application\UseCases\Company\Query\GetCompanyRating\GetCompanyRatingQuery;
use App\Application\UseCases\Company\Query\GetCompanyRating\GetCompanyRatingQueryHandler;
use App\Application\UseCases\Company\Query\GetTopCompanyByRating\GetTopCompanyByRatingQuery;
use App\Application\UseCases\Company\Query\GetTopCompanyByRating\GetTopCompanyByRatingQueryHandler;
use App\Presentation\Http\Requests\Company\CreateCompanyRequest;
use App\Presentation\Http\Requests\Company\UpdateCompanyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompanyController extends Controller
{
    public function __construct(
        private readonly GetCompanyByIdQueryHandler $getCompanyByIdQueryHandler,
        private readonly GetCompanyLogoQueryHandler $getCompanyLogoQueryHandler,
        private readonly GetCompanyRatingQueryHandler $getCompanyRatingQueryHandler,
        private readonly GetTopCompanyByRatingQueryHandler $getTopCompanyByRatingQueryHandler,
        private readonly CreateCompanyCommandHandler $createCompanyCommandHandler,
        private readonly UpdateCompanyCommandHandler $updateCompanyCommandHandler,
        private readonly DeleteCompanyLogoCommandHandler $deleteCompanyLogoCommandHandler,
        private readonly DeleteCompanyCommandHandler $deleteCompanyCommandHandler
    )
    {
    }
    public function get(int $id): JsonResponse
    {
        $result = $this->getCompanyByIdQueryHandler->handle(new GetCompanyByIdQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Ok', 'data' => $result]);
    }

    public function getCompanyLogo(int $id): StreamedResponse|JsonResponse
    {
        $result = $this->getCompanyLogoQueryHandler->handle(new GetCompanyLogoQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return Storage::response($result);
    }

    public function getCompanyRating(int $id): JsonResponse
    {
        $result = $this->getCompanyRatingQueryHandler->handle(new GetCompanyRatingQuery($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => "Company $id rating", 'data' => $result]);
    }

    public function getTopCompanyByRating(): JsonResponse
    {
        $result = $this->getTopCompanyByRatingQueryHandler->handle(new GetTopCompanyByRatingQuery());

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Top 10 company', 'data' => $result]);
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        $createCompanyDto = $request->toDto();

        $result = $this->createCompanyCommandHandler->handle(New CreateCompanyCommand($createCompanyDto));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Company created successfully!', 'data' => ['id' => $result]]);
    }

    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $updateCompanyDto = $request->toDto();

        $result = $this->updateCompanyCommandHandler->handle(New UpdateCompanyCommand($id, $updateCompanyDto));

        if ($result instanceof ErrorDto)  {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Company updated successfully!', 'data' => ['id' => $id]]);
    }

    public function deleteCompanyLogo(int $id): JsonResponse
    {
        $result = $this->deleteCompanyLogoCommandHandler->handle(new DeleteCompanyLogoCommand($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Company logo deleted successfully!', 'data' => ['id' => $id]]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->deleteCompanyCommandHandler->handle(New DeleteCompanyCommand($id));

        if ($result instanceof ErrorDto) {
            return response()->json([
                'status' => $result->getCode(),
                'message' => 'Error',
                'errors' => $result->getErrorList()
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Company deleted successfully!', 'data' => ['id' => $id]]);
    }
}
