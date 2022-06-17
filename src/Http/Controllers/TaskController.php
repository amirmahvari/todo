<?php
namespace Amirabbas8643\Todo\Http\Controllers;

use Amirabbas8643\Todo\Http\Requests\Task\TaskStoreRequest;
use Amirabbas8643\Todo\Http\Requests\Task\TaskUpdateRequest;
use Amirabbas8643\Todo\Http\Resources\TaskEditResource;
use Amirabbas8643\Todo\Service\LabelService;
use Amirabbas8643\Todo\Service\TaskService;
use Amirabbas8643\Todo\Models\Task;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
        return $this->taskService->getMyTasks();
    }

    /**
     * Show the form for creating a new resource.
     * @return View
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
     * @return Redirector
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
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Task $task): View
    {
        $this->authorize('update' , $task);
        return view('Todo::task.edit' , [
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
    public function add_label(Task $task,$label)
    {
        return $task->labels()->pluck('label_id')->aa;
    }
}
