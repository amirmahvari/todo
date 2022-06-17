<?php

namespace Amirmahvari\Todo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LabelResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id ,
            'label'       => $this->label ,
            'tasks_count' => $this->tasks_count ,
        ];
    }
}
