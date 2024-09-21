<?php

namespace App\Http\Requests;

use App\Constants\ResponseStatus;
use App\Http\Responses\Api\ResponseBuilder;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules() : array
    {
        $UaCellPhoneRegex = config('regex.phone_numbers.cell_phone.ua');

        $this->ensureNoPhoneEmailConflict();

        return [
            'name'        => ['required', 'string', 'min:2', 'max:60'],
            'email'       => ['required', 'min:6', 'max:100', 'email'],
            'phone'       => ['required', 'regex:'.$UaCellPhoneRegex],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'photo'       => [
                'required',
                'image',
                'mimes:jpeg,jpg',
                'max:5120',
                'dimensions:min_width=70,min_height=70',
            ],
        ];
    }

    public function messages() : array
    {
        return [
            'phone.regex'        => __('validation.regex_cell_phone.ua'),
            'position_id.exists' => __('validation.models.positions.exists'),
            'photo.dimensions'   => __('validation.models.users.photo.dimensions'),
            'photo.max'          => __('validation.models.users.photo.size_max'),
        ];
    }

    protected function failedValidation(Validator $validator) : void
    {
        $data = ResponseBuilder::error(
            message    : __('response_messages.validation_error'),
            errors     : $validator->errors(),
            statusCode : ResponseStatus::UNPROCESSABLE_CONTENT,
        );

        throw new HttpResponseException($data);
    }

    private function ensureNoPhoneEmailConflict() : void
    {
        $phone = $this->input('phone');
        $email = $this->input('email');

        $isPhoneExists = User::where('phone', $phone)->exists();
        $isEmailExists = User::where('email', $email)->exists();

        if ($isEmailExists || $isPhoneExists) {
            $message = __('validation.phone_or_email_already_exists');

            throw new HttpResponseException(ResponseBuilder::conflict($message));
        }
    }
}
