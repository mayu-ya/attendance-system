<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_time' => ['after:end_time'],
            'end_time' => ['befoer:start_time'],
            'rest_start' => ['before:start_time', 'after:end_time'],
            'rest_end' => ['after:end_time'],
            'content' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'start_time.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'end_time.before' => '出勤時間もしくは退勤時間が不適切な値です',
            'rest_start.befoer' => '休憩時間が不適切な値です',
            'rest_start.after' => '休憩時間が不適切な値です',
            'rest_end.after' => '休憩時間もしくは退勤時間が不適切な値です',
            'content.required' => '備考を記入してください',
        ];
    }
}
