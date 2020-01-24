<?php

namespace App\API\Conference\Rules;

use Throwable;
use Illuminate\Contracts\Validation\Rule;
use App\API\Conference\ValueObjects\TalkInfo;
use Illuminate\Contracts\Validation\ImplicitRule;

class TalkTitleRule implements ImplicitRule
{
    private string $validationMessage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @SuppressWarnings(PHPMD)
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $talkInfo = new TalkInfo($value);
        } catch (Throwable $exception) {
            $this->validationMessage = "{$value}::{$exception->getMessage()}";

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->validationMessage;
    }
}
