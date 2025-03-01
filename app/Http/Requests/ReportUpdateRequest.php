<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporUpdateRequest extends FormRequest
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
            'fortnight_id' => 'sometimes',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'user_id' => 'sometimes|array',
            'department_id' => 'sometimes|array',
        ];
    }
}
