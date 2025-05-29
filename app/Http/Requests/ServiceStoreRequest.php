<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'customer_name' => 'required',
            'chassis_number' => 'required',
            'km_run' => 'required|numeric',
            'bay_number' => 'required',
            'charge' => 'required_if:type,2|numeric',
            'type' => 'required|in:1,2',
            'start_time' => 'required',
            'parts' => 'nullable|array',
            'phone' => 'required',
            'img' => 'nullable|file',
        ];
    }
}
