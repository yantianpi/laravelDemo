<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailValidateRequest extends FormRequest
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
            'formData.mailName' => 'sometimes|required',
            'formData.mailMail' => 'sometimes|required|email',
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
            'formData.mailName.required' => '邮件名必填',
            'formData.mailMail.required' => '邮箱必填',
            'formData.mailMail.email' => '邮箱非法',
        ];
    }
}
