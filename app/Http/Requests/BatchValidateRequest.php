<?php

namespace Peteryan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchValidateRequest extends FormRequest
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
            'formData.batchName' => 'sometimes|required',
            'formData.batchCrontime' => 'sometimes|required',
            'formData.batchThroughput' => 'sometimes|required|numeric|min:10',
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
            'formData.batchName.required' => '批次名必填',
            'formData.batchCrontime.required' => 'crontime必填',
            'formData.batchThroughput.required' => '批量处理吞吐量必填',
            'formData.batchThroughput.numeric' => '批量处理吞吐量为整数',
            'formData.batchThroughput.min' => '批量处理吞吐量最小为10',
        ];
    }
}
