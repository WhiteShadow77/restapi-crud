<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\Task\TaskResourceControllerInterface;
use Illuminate\Http\Request;
use App\Services\Task\TaskService;

class TaskController extends Controller //implements TaskResourceControllerInterface
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->taskService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->taskService->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return $this->taskService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->taskService->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->taskService->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        return $this->taskService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->taskService->destroy($id);
    }

    public function attacheCategory(string $id, string $categoryId)
    {
        return $this->taskService->attacheCategory($id, $categoryId);
    }
}
