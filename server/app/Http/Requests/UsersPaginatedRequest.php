<?php

namespace App\Http\Requests;

use App\Constants\ResponseStatus;
use App\Http\Responses\Api\ResponseBuilder;
use App\Rules\MaxPageRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersPaginatedRequest extends FormRequest
{
    public function rules() : array
    {
        $pageCount = $this->input('count');
        $page = $this->input('page');

        return [
            'page'  => ['required', 'numeric', 'min:1', new MaxPageRule($pageCount, $page)],
            'count' => ['required', 'numeric', 'min:1'],
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
}
