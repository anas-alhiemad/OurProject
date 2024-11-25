<?php

namespace App\Http\Requests\Files;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends BaseRequest
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
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ];
    }
}
