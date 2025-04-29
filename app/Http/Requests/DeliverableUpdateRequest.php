<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliverableUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'deadline' => 'nullable|string|max:255',
            'is_completed' => 'nullable|string',
            'comment' => 'nullable|string',
            'commented_by'=> 'nullable|string',
        ];
    }
}
