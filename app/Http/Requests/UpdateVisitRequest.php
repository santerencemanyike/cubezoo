<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

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
