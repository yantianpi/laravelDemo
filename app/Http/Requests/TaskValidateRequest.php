<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskValidateRequest extends FormRequest
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
            'formData.taskName' => 'sometimes|required',
            'formData.taskCategory' => [
                'bail',
                'sometimes',
                'required',
                'numeric',
                Rule::exists('category_list', 'Id')->where(function ($query) {
                    $query->where('Status', 'ACTIVE');
                }),
            ],
            'formData.taskProject' => [
                'bail',
                'sometimes',
                'required',
                'numeric',
                Rule::exists('project_list', 'Id')->where(function ($query) {
                    $query->where('Status', 'ACTIVE');
                }),
            ],
            'formData.Batch' => 'bail|sometimes|required|numeric|min:0',
            'formData.taskAlertLimit' => 'bail|sometimes|required|numeric|min:1',
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
            'formData.taskName.required' => '任务名必填',
            'formData.taskCategory.required'  => '分类必选',
            'formData.taskCategory.numeric'  => '分类不合法',
            'formData.taskCategory.exists'  => '分类不存在',
            'formData.taskProject.required'  => '项目必选',
            'formData.taskProject.numeric'  => '项目不合法',
            'formData.taskProject.exists'  => '项目不存在',
            'formData.Batch.required'  => '批次必选',
            'formData.Batch.numeric' => '批次不合法',
            'formData.taskAlertLimit.required'  => '预警上限必填',
            'formData.taskAlertLimit.numeric' => '预警上限必须是整数',
            'formData.taskAlertLimit.min' => '预警上限必须大于0',
        ];
    }
}
