<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        if (isset($data['status']) && $data['status'] === 'Completed' && $task->status !== 'In Progress') {
            throw new \Exception('Cannot mark task as completed unless it is in progress.');
        }

        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Task::all();
    }

    public function findById($id): ?Task
    {
        return Task::find($id);
    }

    public function getFilteredTasks(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        $query = Task::query();    

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('due_date', [$filters['start_date'], $filters['end_date']]);
        }

        if (isset($filters['sort_by']) && in_array($filters['sort_by'], ['priority', 'due_date', 'created_at'])) {
            $sortOrder = isset($filters['sort_order']) ? $filters['sort_order'] : 'asc';    
            $query->orderBy($filters['sort_by'], $sortOrder);
        }

        return $query->get();  
    }

    public function searchTasks(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Task::query()
            ->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$query])
            ->get();
    }

}
