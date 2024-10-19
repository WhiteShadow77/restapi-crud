<?php

namespace App\Services\Category;


use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ResponseService;
use App\Http\Resources\CategoryResource;

class CategoryService implements CategoryResourceControllerInterface
{
    private ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return $this->responseService->successResponseWithResourceCollection(
            'All categories',
            CategoryResource::class,
            Category::all()
        );
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

}