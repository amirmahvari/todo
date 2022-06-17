<?php

namespace Amirabbas8643\Todo\Http\Controllers\Api;

use Amirabbas8643\Todo\Http\Controllers\Controller;
use Amirabbas8643\Todo\Http\Facades\JsonResponse;
use Amirabbas8643\Todo\Http\Requests\Label\LabelStoreRequest;
use Amirabbas8643\Todo\Http\Requests\Label\LabelUpdateRequest;
use Amirabbas8643\Todo\Http\Resources\LabelResource;
use Amirabbas8643\Todo\Models\Label;
use Amirabbas8643\Todo\Service\LabelService;
use Illuminate\Auth\Access\AuthorizationException;

class LabelController extends Controller
{

    private $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function index()
    {
        $labels = $this->labelService->getLabels();
        $labels->setCollection(LabelResource::collection($labels->getCollection())->collection);

        return JsonResponse::success($labels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function store(LabelStoreRequest $request)
    {
        $label = $this->labelService->createLabel($request);


        return JsonResponse::success(new LabelResource($label) , __('Created Label'));
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function show(Label $label)
    {
        return JsonResponse::success((new LabelResource($label)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Label $label
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function update(LabelUpdateRequest $request , Label $label)
    {
        $this->labelService->updateLabel($request , $label);

        return JsonResponse::success(new LabelResource($label) , __('Updated Label'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return \Amirabbas8643\Todo\Http\Responses\JsonResponse
     */
    public function destroy(Label $label)
    {
        $this->labelService->delete($label);

        return JsonResponse::success(null , __('Deleted Label'));
    }
}
