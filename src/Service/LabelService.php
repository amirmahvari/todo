<?php
namespace Amirmahvari\Todo\Service;

use Amirmahvari\Todo\Models\Label;
use Illuminate\Http\Request;

class LabelService
{
    /**
     * @param int $length
     */
    public function getLabels($length = 10)
    {
        return Label::withCount('tasks')
            ->orderBy('id','desc')
            ->paginate($length);
    }

    public function getList()
    {
        return Label::all();
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return array
     */
    protected function binding(Request $request): array
    {
        return [
            'label' => $request->get('label') ,
        ];
    }

    /**
     * @param Request $request
     * @return Label
     */
    public function createLabel(Request $request): Label
    {
        return Label::create($this->binding($request));
    }

    public function updateLabel(Request $request , Label $label)
    {
        return $label->update($this->binding($request));
    }

    public function delete(Label $label)
    {
        $label->tasks()->detach();
        $label->delete();
    }
}
