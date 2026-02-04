<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliverableStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:deliverables,name,NULL,id,fortnight_id,' . ($this->input('fortnight_id') ?? ''),
            'deadline' => 'nullable|date',
            'fortnight_id' => 'required|exists:fortnights,id',
            'comment' => 'nullable|string', 
            
        ];
    }
}
