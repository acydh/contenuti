<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Create extends FormRequest
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
            'required',
            Rule::unique('articles')
          ],
          'abstract' => 'required|string|max:255',
          'contents' => 'required|string|max:500',
          'status' => [
            'nullable',
            'sometimes',
            Rule::in(['0', '1'])
          ]
        ];
    }
}
