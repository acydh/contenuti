<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Update extends FormRequest
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
        return [
          'title' => [
            'nullable',
            'sometimes',
            'max:100',
            Rule::unique('articles')
          ],
          'abstract' => 'nullable|sometimes|string|max:255',
          'contents' => 'nullable|sometimes|string|max:500',
          'status' => [
            'nullable',
            'sometimes',
            Rule::in(['0', '1'])
          ]
        ];
    }
}
