<?php

namespace App\Http\Controllers\ExampleModule;

use App\Http\Controllers\ExampleModule\ExampleFunction\Dto\GetIsOddResponseDTO;
use App\Http\Controllers\ExampleModule\ExampleFunction\ExampleService;
use App\Http\Controllers\ExampleModule\ExampleFunction\Exception\TestingException;
use Cuakx\Core\DTO\BaseResponseDTO;
use Cuakx\Core\Http\Controllers\BaseController;
use Cuakx\Core\Http\Middleware\AuthCheck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware(AuthCheck::class, only: ['getIsOdd'])]
class ExampleController extends BaseController
{
    public function __construct(private ExampleService $exampleService){}

    /**
     * This function will be not able to execute unless you have a valid access token
     * @param Request $request
     * @return JsonResponse
     */
    public function getIsOdd(Request $request): JsonResponse {
        $this->baseValidator($request, [
            "number" => "required",
        ]);

        $result = $this->exampleService->isOdd($request->query->get("number"));

        $response = new GetIsOddResponseDTO();
        $response->is_odd = $result;


        return BaseResponseDTO::success("Success", $response);
    }

    public function postIsOdd(Request $request): JsonResponse {
        $this->baseValidator($request, [
            "number" => "required",
        ]);

        $result = $this->exampleService->isOdd($request->request->get("number"));

        $response = new GetIsOddResponseDTO();
        $response->is_odd = $result;


        return BaseResponseDTO::success("Success", $response);
    }

    public function exceptionThrowing(Request $request): JsonResponse {
        throw new TestingException();
    }
}
