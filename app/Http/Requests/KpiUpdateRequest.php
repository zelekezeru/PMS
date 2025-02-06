<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KpiUpdateRequest extends FormRequest
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
            'value' => 'sometimes|numeric|min:0',
            'unit' => 'sometimes|string|max:50',
            'status' => 'sometimes|string|max:50',
            'task_id' => 'sometimes|exists:tasks,id',
            'target_id' => 'sometimes|exists:targets,id',
            'approved_by' => 'sometimes|string|max:50',
            'confirmed_by' => 'sometimes|string|max:50',
        ];
    }
}
