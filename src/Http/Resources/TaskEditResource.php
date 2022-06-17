<?php
namespace Amirmahvari\Todo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskEditResource extends JsonResource
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
            'title'       => $this->title ,
            'description' => $this->description ,
            'status'      => $this->status ,
            'labels'      => $this->labels()
                ->pluck('id')
                ->toArray() ,
        ];
    }
}
