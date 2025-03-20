<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'department_name' => 'required|string|max:255|unique:departments,department_name,'.$this->department->id,
            'description' => 'string|max:255|sometimes',
            'department_head' => 'sometimes',
        ];
    }
}
