<?php
namespace Amirabbas8643\Todo\Http\Controllers;

use Amirabbas8643\Todo\Http\Requests\Task\TaskStoreRequest;
use Amirabbas8643\Todo\Http\Requests\Task\TaskUpdateRequest;
use Amirabbas8643\Todo\Http\Resources\TaskEditResource;
use Amirabbas8643\Todo\Service\LabelService;
use Amirabbas8643\Todo\Service\TaskService;
use App\Http\Controllers\Controller;
use Amirabbas8643\Todo\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private $taskService;
    private $labelService;

    public function __construct(TaskService $taskService , LabelService $labelService)
    {
        $this->taskService = $taskService;
        $this->labelService = $labelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Todo::task.index' , [
            'tasks'     => $this->taskService->getMyTasks() ,
            'pageTitle' => 'Task List' ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('Todo::task.create' , [
            'labels'    => $this->labelService->getList() ,
            'pageTitle' => __('Task Create') ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TaskStoreRequest $request)
    {
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
     * @return Response
     */
    public function show(Task $task)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $this->authorize('Todo::update' , $task);
        return view('task.edit' , [
            'labels'    => $this->labelService->getList() ,
            'task'      => (new TaskEditResource($task))->resolve() ,
            'pageTitle' => __('Task Edit') ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
}
