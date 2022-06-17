<?php

namespace Amirabbas8643\Todo\Http\Controllers\Api;

use Amirabbas8643\Todo\Http\Controllers\Controller;
use Amirabbas8643\Todo\Http\Facades\JsonResponse;
use Amirabbas8643\Todo\Http\Requests\Task\TaskStoreRequest;
use Amirabbas8643\Todo\Http\Requests\Task\TaskUpdateRequest;
use Amirabbas8643\Todo\Http\Resources\TaskResource;
use Amirabbas8643\Todo\Models\Task;
use Amirabbas8643\Todo\Service\TaskService;
use Illuminate\Routing\Redirector;

class TaskController extends Controller
{

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function index()
    {
        $tasks = $this->taskService->getMyTasks();
        $tasks->setCollection(TaskResource::collection($tasks->getCollection())->collection);

        return JsonResponse::success($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Redirector
     */
    public function store(TaskStoreRequest $request)
    {
        dd('$vars');
        $task = $this->taskService->createTask($request);
        if(is_array($request->get('labels')))
        {
            $this->taskService->attachLabels($task , $request->get('labels'));
        }

        return redirect(route('task.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function show(Task $task)
    {
        $this->authorize('update' , $task);

        return JsonResponse::success((new TaskResource($task)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task $task
     * @return Redirector
     */
    public function update(TaskUpdateRequest $request , Task $task)
    {
        $this->authorize('update' , $task);
        $this->taskService->updateTask($request , $task);
        if(is_array($request->get('labels')))
        {
            $this->taskService->syncLabels($task , $request->get('labels'));
        }

        return redirect(route('task.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete' , $task);
        $this->taskService->delete($task);

        return redirect(route('label.index'));
    }

    /**
     * @param Task $task
     */
    public function add_label(Task $task , $label)
    {
        return $task->labels()
            ->pluck('label_id')->aa;
    }
}
