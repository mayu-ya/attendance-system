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
            'start_time' => ['before:end_time'],
            'end_time' => ['after:start_time'],
            'breaks.*.rest_start' => ['after:start_time', 'before:end_time'],
            'breaks.*.rest_end' => ['before:end_time'],
            'rest.rest_start' => ['nullable', 'after:start_time', 'before:end_time'],
            'rest.rest_end' => ['nullable', 'before:end_time'],
            'content' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'start_time.before' => '出勤時間もしくは退勤時間が不適切な値です',
            'end_time.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'breaks.*.rest_start.after' => '休憩時間が不適切な値です',
            'breaks.*.rest_start.before' => '休憩時間が不適切な値です',
            'rest.rest_start.after' => '休憩時間が不適切な値です',
            'rest.rest_start.before' => '休憩時間が不適切な値です',
            'rest.rest_end.before' => '休憩時間もしくは退勤時間が不適切な値です',
            'content.required' => '備考を記入してください',
        ];
    }
}
