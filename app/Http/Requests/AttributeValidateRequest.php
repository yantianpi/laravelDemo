<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeValidateRequest extends FormRequest
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
            'formData.attributeName' => 'sometimes|required',
            'formData.attributeCategory' => [
                'sometimes',
                'required',
                'numeric',
                Rule::exists('category_list', 'Id')->where(function ($query) {
                    $query->where('Status', 'ACTIVE');
                }),
            ]
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
            'formData.attributeName.required' => '属性名必填',
            'formData.attributeCategory.required'  => '分类必选',
            'formData.attributeCategory.numeric'  => '分类不合法',
            'formData.attributeCategory.exists'  => '分类不存在',
        ];
    }
}
