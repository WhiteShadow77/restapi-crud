<?php

namespace App\Services\Task;


use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Task;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class TaskService implements TaskResourceControllerInterface
{
    private ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index()
    {
        return $this->responseService->successResponseWithResourceCollection(
            'All tasks',
            TaskResource::class,
            Task::all()
        );
    }

    public function create()
    {
        //
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return $this->responseService->successResponse('Task created', 201);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

}