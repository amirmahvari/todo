<?php

namespace Amirmahvari\Todo\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskStatusRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->task->user_id == auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'in:open,close'],
        ];
    }
}
