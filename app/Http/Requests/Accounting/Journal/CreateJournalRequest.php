<?php

namespace App\Http\Requests\Accounting\Journal;

use Illuminate\Foundation\Http\FormRequest;

class CreateJournalRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => 'required|date:format:Y-m-d',
            'description' => 'required|string',
        ];
    }
}
