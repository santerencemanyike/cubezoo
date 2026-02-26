<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_id' => [
                'required',
                'exists:sites,id'
            ],
            'visited_at' => [
                'required',
                'date'
            ],
            'notes' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }
}
