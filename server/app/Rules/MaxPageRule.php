<?php

namespace App\Rules;

use App\Constants\ResponseStatus;
use App\Http\Responses\Api\ResponseBuilder;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class MaxPageRule implements ValidationRule
{
    private mixed $pageCount;
    private mixed $page;

    public function __construct(mixed $pageCount, mixed $page)
    {
        $this->pageCount = $pageCount;
        $this->page = $page;
    }

    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $isPageSizeValid = is_numeric($this->pageCount);
        $isPageValid = is_numeric($this->page);

        if ($isPageSizeValid && $isPageValid) {
            $maxPage = ceil(User::count() / $this->pageCount);

            if ($this->page > $maxPage) {
                $data = ResponseBuilder::error(
                    message    : __('response_messages.page_not_found'),
                    statusCode : ResponseStatus::NOT_FOUND,
                );

                throw new HttpResponseException($data);
            }
        }
    }
}
