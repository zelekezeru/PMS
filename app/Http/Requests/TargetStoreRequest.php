<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetStoreRequest extends FormRequest
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
            'budget' => 'sometimes|string|max:255',
            'value' => 'sometimes|numeric|min:0',
            'unit' => 'sometimes|string|max:50',
            'goal_id' => 'required|exists:goals,id',
            'departments' => 'sometimes|array|max:255',
            'year_id'=> 'required|exists:years,id',
        ];
    }
}
