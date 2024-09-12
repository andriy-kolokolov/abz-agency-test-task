<?php

namespace App\Http\Requests;

use App\Constants\ResponseStatus;
use App\Http\Responses\ApiResponseBuilder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules() : array
    {
        $UaCellPhoneRegex = config('regex.phone_numbers.cell_phone.ua');

        return [
            'name'        => ['required', 'string', 'min:2', 'max:60'],
            'email'       => ['required', 'min:6', 'max:100', 'email', 'unique:users,email'],
            'phone'       => ['required', 'regex:'.$UaCellPhoneRegex],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            //            'photo'       => ['required', 'image', 'mimes:jpeg,jpg', 'max:5120'],
        ];
    }

    protected function failedValidation(Validator $validator) : void
    {
        $data = ApiResponseBuilder::error(
            message    : __('response_messages.validation_error'),
            errors     : $validator->errors(),
            statusCode : ResponseStatus::UNPROCESSABLE_CONTENT,
        );

        throw new HttpResponseException($data);
    }

    public function messages() : array
    {
        return [
            'phone.regex' => __('validation.regex_cell_phone.ua'),
        ];
    }

    private function validatePhotoSize() : void
    {
        // photo must be 70 X 70 min
        // TODO: Implement validatePhotoSize() method.
    }
}
