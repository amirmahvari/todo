<?php

namespace Amirmahvari\Todo\Http\Controllers\Api;

use Amirmahvari\Todo\Http\Controllers\Controller;
use Amirmahvari\Todo\Http\Facades\JsonResponse;
use Amirmahvari\Todo\Http\Requests\Task\TaskStoreRequest;
use Amirmahvari\Todo\Http\Requests\Task\TaskUpdateRequest;
use Amirmahvari\Todo\Http\Resources\TaskResource;
use Amirmahvari\Todo\Models\Task;
use Amirmahvari\Todo\Service\TaskService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
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
     * @return \Amirmahvari\Todo\Http\Responses\JsonResponse
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
     * @return \Amirmahvari\Todo\Http\Responses\JsonResponse
     */
    public function store(TaskStoreRequest $request)
    {
        $task = $this->taskService->createTask($request);
        if(is_array($request->get('labels')))
        {
            $this->taskService->attachLabels($task , $request->get('labels'));
        }

        return JsonResponse::success(new TaskResource($task),__('Created Task'));
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Amirmahvari\Todo\Http\Responses\JsonResponse
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
     * @return \Amirmahvari\Todo\Http\Responses\JsonResponse
     */
    public function update(TaskUpdateRequest $request , Task $task)
    {
        $this->authorize('update' , $task);
        $this->taskService->updateTask($request , $task);
        if(is_array($request->get('labels')))
        {
            $this->taskService->syncLabels($task , $request->get('labels'));
        }

        return JsonResponse::success(new TaskResource($task),__('Updated Task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Amirmahvari\Todo\Http\Responses\JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete' , $task);
        $this->taskService->delete($task);
        return JsonResponse::success(null,__('Deleted Task'));
    }

}
