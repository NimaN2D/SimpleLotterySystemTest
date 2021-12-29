<?php

namespace App\Http\Requests;

use App\Models\Lottery;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateLotteryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique(with(new Lottery)->getTable())->ignore($this->lottery->id)->whereNot('is_held',1)
            ],
            'maximum_winners' => 'required|integer|min:1',
            'due_date' => 'nullable|date:Y/m/d|after:today',
        ];
    }
}
