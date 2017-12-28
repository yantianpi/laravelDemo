<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValidateRequest extends FormRequest
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
            'formData.categoryName' => 'sometimes|required',
        ];
    }

    /**
     * 自定义错误消息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'formData.categoryName.required' => '分类名必填',
        ];
    }
}
