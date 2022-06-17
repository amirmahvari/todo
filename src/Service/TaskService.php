<?php

namespace Amirmahvari\Todo\Service;

use Amirmahvari\Todo\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    /**
     * @param int $length
     */
    public function getMyTasks($length = 10)
    {
        return Task::with('labels')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate($length);
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return array
     */
    protected function binding(Request $request, $user_id): array
    {
        return [
            'title'       => $request->get('title'),
            'description' => $request->get('description'),
            'status'      => 'open',
            'user_id'     => $user_id,
        ];
    }

    /**
     * @param Request $request
     * @return Task
     */
    public function createTask(Request $request): Task
    {
        return Task::create($this->binding($request, auth()->id()));
    }

    /**
     * @param Task $task
     * @param array $labels
     */
    public function attachLabels(Task $task, array $labels)
    {
        $task->labels()->attach($labels);
    }

    /**
     * @param Task $task
     * @param array $labels
     */
    public function syncLabels(Task $task, array $labels)
    {
        $task->labels()->sync($labels);
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return bool
     */
    public function updateTask(Request $request, Task $task)
    {
        return $task->update($this->binding($request, $task->user_id));
    }

    /**
     * @param Task $task
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Task $task)
    {
        $task->labels()->detach();
        return $task->delete();
    }


    /**
     * @param Task $task
     * @return bool|null
     * @throws \Exception
     * change status
     */
    public function changeStatus(Task $task, $status)
    {
        return $task->update(['status' => $status]);
    }
}
