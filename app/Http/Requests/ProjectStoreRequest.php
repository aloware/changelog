<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectStoreRequest extends FormRequest
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
    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => 'required|unique:projects',
            'company_id' => [
                'integer',
                Rule::exists('companies', 'id')->where('company_id', $user->company->id)
            ],
            'logo' => 'string',
            'url' => 'string',
            'terminology' => [
                'integer',
                Rule::in([ Project::TERMINOLOGY_CHANGELOG, Project::TERMINOLOGY_RELEASE_NOTES, Project::TERMINOLOGY_UPDATES, Project::TERMINOLOGY_NEWS ])
            ]
        ];
    }
}
