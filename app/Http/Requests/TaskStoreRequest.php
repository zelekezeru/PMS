<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
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
            'description' => 'required|string',
            'budget' => 'sometimes|string|max:255',
            'barriers' => 'required|string|max:255',
            'comunication' => 'required|string|max:255',
            'status' => 'sometimes|string|max:255',
            'user_id' => 'required|exists:users,id',
            'starting_date' => 'sometimes|date',
            'due_date' => 'sometimes|date',
            'target_id' => 'sometimes|nullable|exists:targets,id',
            'department_id' => 'sometimes|array',
            'fortnight_id' => 'sometimes|array',
            'created_by' => 'required',
        ];
    }
}
