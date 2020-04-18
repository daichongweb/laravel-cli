<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class MainRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'bail|required|max:40|unique:shop,name,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.unique' => '名称已存在',
            'name.max'  => '名称的最大长度为40位',
        ];
    }

    public function withValidate(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function getCurrentValidator()
    {
        return $this->validator;
    }

    public function failedValidation(Validator $validator)
    {
    }
}
