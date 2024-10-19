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
        return $this->responseService->errorResponse('Method not allowed', 405);
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

    public function edit(string $id)
    {
        return $this->responseService->errorResponse('Method not allowed', 405);
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::where('id', $id)->update($request->all());

        if(!$category){
            return $this->responseService->errorResponse('Category not found', 404);
        } else {
            return $this->responseService->successResponse('Category updated', 200);
        }
    }

    public function destroy(string $id)
    {
        $category = Category::where('id', $id)->delete();
        if($category) {
            return $this->responseService->successResponse('Category deleted');
        } else {
            return $this->responseService->errorResponse('Category not found', 404);
        }
    }

}