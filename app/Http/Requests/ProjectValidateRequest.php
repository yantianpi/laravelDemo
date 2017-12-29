<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectValidateRequest extends FormRequest
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
            'formData.projectName' => 'sometimes|required',
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
            'formData.projectName.required' => '工程名必填',
        ];
    }
}
