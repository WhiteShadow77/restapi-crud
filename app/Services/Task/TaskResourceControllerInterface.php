<?php


namespace App\Services\Task;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;


interface TaskResourceControllerInterface
{
    public function index();

    public function create();

    public function store(StoreTaskRequest $request);

    public function show(string $id);

    public function edit(string $id);

    public function update(Request $request, string $id);

    public function destroy(string $id);
}