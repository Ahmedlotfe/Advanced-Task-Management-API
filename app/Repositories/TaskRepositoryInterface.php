<?php

namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;
    public function update(Task $task, array $data): bool;
    public function delete(Task $task): bool;
    public function getAll(): \Illuminate\Database\Eloquent\Collection;
    public function findById($id): ?Task;
    public function getFilteredTasks(array $filters): \Illuminate\Database\Eloquent\Collection;
    public function searchTasks(string $query): \Illuminate\Database\Eloquent\Collection;
}
