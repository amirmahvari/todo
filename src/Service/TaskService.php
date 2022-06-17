<?php
namespace Amirabbas8643\Todo\Service;
use Amirabbas8643\Todo\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    /**
     * @param int $length
     */
    public function getMyTasks($length = 10)
    {
        return Task::where('user_id' , auth()->id())
            ->orderBy('id','desc')
            ->paginate($length);
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return array
     */
    protected function binding(Request $request , $user_id): array
    {
        return [
            'title'       => $request->get('title') ,
            'description' => $request->get('description') ,
            'status'      => $request->get('status' , 'open') ,
            'user_id'     => $user_id ,
        ];
    }

    /**
     * @param Request $request
     * @return Task
     */
    public function createTask(Request $request): Task
    {
        return Task::create($this->binding($request , auth()->id()));
    }

    public function attachLabels(Task $task,array $labels)
    {
        $task->labels()->attach($labels);
    }

    public function syncLabels(Task $task,array $labels)
    {
        $task->labels()->sync($labels);
    }

    public function updateTask(Request $request , Task $task)
    {
        return $task->update($this->binding($request , $task->user_id));
    }

    public function delete(Task $task)
    {
        $task->labels()->detach();
       return $task->delete();
    }
}
