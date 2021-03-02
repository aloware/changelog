<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangelogStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'category_id' => [
                'integer',
                Rule::exists('categories', 'id')->where('company_id', $user->company->id)
            ],
            'project_id' => [
                'integer',
                Rule::exists('projects', 'id')->where('company_id', $user->company->id)
            ]
        ];
    }
}
