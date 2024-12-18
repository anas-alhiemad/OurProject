<?php

namespace App\Http\Requests\Files;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends BaseRequest
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
            "name" => "required|max:25",
            'group_id' => 'required|exists:groups,id',
            "file" => "required|file|mimes:docx,excel,pdf,doc,csv,xlsx,xls,ppt,odt,ods,odp",
        ];
    }
}
