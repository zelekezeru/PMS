<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KpiStoreRequest extends FormRequest
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
            'value' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'task_id' => 'nullable|exists:tasks,id',
            'target_id' => 'nullable|exists:targets,id',
        ];
    }
}
