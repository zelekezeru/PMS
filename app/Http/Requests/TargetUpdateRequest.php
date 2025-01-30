<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetUpdateRequest extends FormRequest
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
            'budget' => 'sometimes|nullable|string|max:255',
            'value' => 'sometimes|nullable|numeric|min:0',
            'unit' => 'sometimes|nullable|string|max:50',
            'goal_id' => 'sometimes|required|exists:goals,id',
            'departments' => 'sometimes|array|max:255',
        ];
    }
}
