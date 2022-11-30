<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'isbn' => 'required|digits:13|integer|unique:books,isbn,'.$this->id.'',
            'name' => 'required|min:3',
            'year' => 'required|integer|digits:4',
            'page' => 'required|integer',
            'publisher_id' => 'exists:publishers,id',
            'authors' => 'array',
            'authors.*' => 'exists:authors,id'
        ];
    }
}
