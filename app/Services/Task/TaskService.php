<?php

namespace App\Services\Task;


use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Category;
use App\Models\Task;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Enums\CategoryStatusType;
use Illuminate\Support\Facades\DB;

class TaskService //implements TaskResourceControllerInterface
{
private ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index(Request $request)
    {
        if($request->has('category_sort')){

            //dd($request->get('category_sort'));

            $result = DB::table('tasks')
                ->join('categories', 'categories.id', '=', 'tasks.category_id')
                ->select([
                    'tasks.id',
                    'tasks.name',
                    'tasks.description',
                    'tasks.done_at',
                    'tasks.created_at',
                    'tasks.updated_at',
                    'categories.type as category_type',
                    'categories.name as category_name',
                ])
                ->orderByRaw(
                    'category_' . key($request->get('category_sort')) . ' ' . current($request->get('category_sort'))
                )
                ->get();

            //dd($result);

            return $this->responseService->successResponseWithResourceCollection(
                'All tasks sorted by category ' . current($request->get('category_sort')),
                TaskResource::class,
                $result
            );
        } else {
            return $this->responseService->successResponseWithResourceCollection(
                'All tasks',
                TaskResource::class,
                Task::all()
            );
        }
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

        if (sizeof($task) > 0) {
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
        $updateConfig = $request->all();
        $categoryFromRequest = $request ?->get('category');
        $statusFromRequest = $request ?->get('status');

        if (!is_null($categoryFromRequest)) {
            unset($updateConfig['category']);
        }

        if (!is_null($statusFromRequest)) {
            unset($updateConfig['status']);
        }

        if (!is_null($categoryFromRequest)) {

            if(sizeof($categoryFromRequest) > 0) {

                $category = Category::where(key($categoryFromRequest), current($categoryFromRequest))->first();

                if ($category) {
                    $updateConfig['category_id'] = $category->id;
                } else {
                    return $this->responseService->errorResponse('Category not found', 404);
                }
            } else {
                $updateConfig['category_id'] = null;
            }
        }

        if (!is_null($statusFromRequest)) {

            if ($statusFromRequest == (CategoryStatusType::IN_PROGRESS)->name) {
                $updateConfig['done_at'] = null;
            }
            if ($statusFromRequest == (CategoryStatusType::DONE)->name) {
                $updateConfig['done_at'] = now()->format('Y-m-d H:i:s');
            }
        }

       $task = Task::where('id', $id)->update($updateConfig);

        if (!$task) {
            return $this->responseService->errorResponse('Task not found', 404);
        } else {
            return $this->responseService->successResponse('Task updated', 200);
        }
    }

    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->delete();
        if ($task) {
            return $this->responseService->successResponse('Task deleted');
        } else {
            return $this->responseService->errorResponse('Task not found', 404);
        }
    }

    public function attacheCategory(string $id, string $categoryId)
    {
        $task = Task::where('id', $id)->update([
            'category_id' => $categoryId
        ]);

        if ($task) {
            return $this->responseService->successResponse('Category attached', 200);
        } else {
            return $this->responseService->errorResponse('Task not found', 404);
        }
    }

}