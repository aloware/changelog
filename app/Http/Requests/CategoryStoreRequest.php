<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = $this->user();

        return [
            'label' =>
                [
                'required',
                Rule::unique('categories', 'id')->ignore($this->id)
            ],
            'company_id' => [
                'integer',
                Rule::exists('companies', 'id')->where('id', $user->company->id)
            ],
            'bg_color' => 'string',
            'text_color' => 'string',
        ];
    }
}
