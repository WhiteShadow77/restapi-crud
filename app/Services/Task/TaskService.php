<?php

namespace App\Services\Task;


use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Task;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Enums\CategoryStatusType;

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
        return $this->responseService->errorResponse('Method not allowed', 405);
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
        $task = Task::where('id', $id)->get();

        if(sizeof($task) > 0) {
            return $this->responseService->successResponseWithResourceCollection(
                'Task by id',
                TaskResource::class,
                $task
            );
        } else {
            return $this->responseService->errorResponse('Task not found', 404);
        }

    }

    public function edit(string $id)
    {
        return $this->responseService->errorResponse('Method not allowed', 405);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $categoryFromRequest = $request?->get('category');
        $statusFromRequest = $request?->get('status');

        if(!is_null($categoryFromRequest)){
            $category = [$categoryFromRequest];
        } else {
            $category = [];
        }

        if(!is_null($statusFromRequest)){
            $status = [$statusFromRequest];
        } else {
            $status = [];
        }

        $updateConfig = array_diff(
            $request->all(),
             $category,
             $status
        );

        if(!is_null($categoryFromRequest)){

        }

        if(!is_null($statusFromRequest)){

            if($statusFromRequest == (CategoryStatusType::IN_PROGRESS)->name){

            }
            if($statusFromRequest == (CategoryStatusType::DONE)->name){
                $updateConfig['done_at'] = now()->format('Y-m-d H:i:s');
            }
        }

        $task = Task::where('id', $id)->update($updateConfig);

        if(!$task){
            return $this->responseService->errorResponse('Task not found', 404);
        } else {
            return $this->responseService->successResponse('Task updated', 200);
        }
    }

    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->delete();
        if($task) {
            return $this->responseService->successResponse('Task deleted');
        } else {
            return $this->responseService->errorResponse('Task not found', 404);
        }
    }

}