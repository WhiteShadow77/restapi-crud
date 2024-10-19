<?php


namespace App\Services\Category;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;


interface CategoryResourceControllerInterface
{
    public function index();

    public function create();

    public function store(StoreCategoryRequest $request);

    public function show(string $id);

    public function edit(string $id);

    public function update(UpdateCategoryRequest $request, string $id);

    public function destroy(string $id);
}