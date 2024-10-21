<?php

namespace App\Services;


use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ResponseService;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Gate;

class CategoryService
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

    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        return $this->responseService->successResponse('Category created', 201);
    }

    public function show(string $id)
    {
        $category = Category::where('id', $id)->get();

        if(sizeof($category) > 0) {
            return $this->responseService->successResponseWithResourceCollection(
                'Category by id',
                CategoryResource::class,
                $category
            );
        } else {
            return $this->responseService->errorResponse('Category not found', 404);
        }
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {

            return $this->responseService->errorResponse('Category not found', 404);

        } else {
            if(Gate::allows('update', $category)) {

                $updateConfig = current($request->all());
                $category->update([key($updateConfig) => $updateConfig]);
                return $this->responseService->successResponse('Category updated', 200);

            } else {

                return $this->responseService->errorResponse('Forbidden', 403);
            }
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {

            return $this->responseService->errorResponse('Category not found', 404);

        } else {
            if(Gate::allows('delete', $category)) {

                $category->delete();
                return $this->responseService->successResponse('Category deleted', 200);

            } else {

                return $this->responseService->errorResponse('Forbidden', 403);
            }
        }
    }
}