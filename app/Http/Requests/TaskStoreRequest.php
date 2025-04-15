<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|string|max:255',
            'barriers' => 'nullable|string|max:255',
            'comunication' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'starting_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'target_id' => 'required|exists:targets,id',
            'department_id' => 'sometimes|array',
            'fortnight_id' => 'sometimes|array',
            'user_id' => 'sometimes|array',
            'created_by' => 'sometimes',
        ];
    }
}
