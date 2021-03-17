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
            'name' => [
                'required',
                Rule::unique('projects')->ignore($user->company->id, 'company_id')
            ],
            'company_id' => [
                'integer',
                'exists:companies,id'
            ],
            //'logo' => 'string',
            'url' => 'string',
            'page_entry_limit' => 'integer',
            'widget_entry_limit' => 'integer',
            'terminology' => [
                'integer',
                Rule::in([ Project::TERMINOLOGY_CHANGELOG, Project::TERMINOLOGY_RELEASE_NOTES, Project::TERMINOLOGY_UPDATES, Project::TERMINOLOGY_NEWS ])
            ]
        ];
    }
}
