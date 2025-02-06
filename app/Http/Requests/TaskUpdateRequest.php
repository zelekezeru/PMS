<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'budget' => 'sometimes|nullable|string|max:255',
            'barriers' => 'sometimes|nullable|string|max:255',
            'comunication' => 'sometimes|nullable|string|max:255',
            'parent_task_id' => 'sometimes|nullable|exists:tasks,id',
            'starting_date' => 'sometimes|nullable|date',
            'due_date' => 'sometimes|nullable|date',
            'target_id' => 'sometimes|required|exists:targets,id',
            'department_id' => 'sometimes|array',
            'fortnight_id' => 'sometimes|array',
            'user_id' => 'sometimes|array',
        ];
    }
}
