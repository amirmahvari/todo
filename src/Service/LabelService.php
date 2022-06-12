<?php
namespace Amirabbas8643\Todo\Service;

use Amirabbas8643\Todo\Models\Label;
use Illuminate\Http\Request;

class LabelService
{
    /**
     * @param int $length
     */
    public function getLabels($length = 10)
    {
        return Label::orderBy('id','desc')
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
        $label->delete();
    }
}
