<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;


class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'start_date', 'end_date', 'sort_by', 'sort_order']);

        $tasks = $this->taskRepository->getFilteredTasks($filters);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $task = $this->taskRepository->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'status' => 'Pending', 
            'priority' => $validatedData['priority'] ?? 'Medium', 
            'user_id' => $validatedData['user_id']
        ]);

        return (new TaskResource($task))
        ->response()
        ->setStatusCode(201);
    }

    public function show($id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404); 
        }

        return new TaskResource($task);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, $id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404); 
        }

        if ($task->status == 'Pending' && $request->input('status') == 'Completed') {
            return response()->json([
                'message' => 'Cannot mark task as completed unless it is in progress.'
            ], 400);
        }

        try {
            $this->taskRepository->update($task, [
                'status' => $request->input('status'),
            ]);

            return new TaskResource($task);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400); 
        }
    }

    public function destroy($id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404); 
        }

        $task->delete();

        return response()->json(['message' => 'Task soft deleted successfully.'], 200); 
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json(['message' => 'Search query is required.'], 400);
        }

        $tasks = $this->taskRepository->searchTasks($query);

        return TaskResource::collection($tasks);
    }
}
