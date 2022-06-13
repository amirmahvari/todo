<?php
namespace Amirabbas8643\Todo\Http\Controllers;

use Amirabbas8643\Todo\Http\Requests\Label\LabelStoreRequest;
use Amirabbas8643\Todo\Http\Requests\Label\LabelUpdateRequest;
use App\Http\Controllers\Controller;
use Amirabbas8643\Todo\Service\LabelService;
use Amirabbas8643\Todo\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LabelController extends Controller
{
    private $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->middleware([
            \Illuminate\Session\Middleware\StartSession::class ,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class ,
            'auth'
        ]);
        $this->labelService = $labelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('label.index' , [
            'labels'     => $this->labelService->getLabels() ,
            'pageTitle' => 'Label List',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('label.create' , [
            'pageTitle' => __('Create Label') ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LabelStoreRequest $request)
    {
        $this->labelService->createLabel($request);
        return redirect(route('label.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return Response
     */
    public function show(Label $label)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Label $label)
    {
        return view('label.edit' , [
            'label'      => $label ,
            'pageTitle' => __('Edit Label'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Label $label
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LabelUpdateRequest $request , Label $label)
    {
        $this->labelService->updateLabel($request , $label);
        return redirect(route('label.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Label $label)
    {
        $this->labelService->delete($label);
        return redirect(route('label.index'));
    }
}
