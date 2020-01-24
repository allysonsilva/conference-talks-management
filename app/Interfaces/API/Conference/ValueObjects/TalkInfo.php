<?php

namespace App\API\Conference\ValueObjects;

use DomainException;
use BadMethodCallException;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use UnexpectedValueException;

final class TalkInfo
{
    private string $title;

    private int $minutes;

    private const LIGHTNING_TALK = 'lightning';
    private const LIGHTNING_MINUTES = 5;

    public function __construct(string $info)
    {
        $this->title = trim($info);

        $this->validateInfo($info);
        $this->handleMinutes($info);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }

    /**
     * @SuppressWarnings("UndefinedVariable")
     *
     * @param string $info
     *
     * @return void
     */
    private function validateInfo(string $info): void
    {
        preg_match_all('/[1-9]\d*|0\d+/', $info, $matches);

        if ($this->existsManyNumbersInTalkTitle($matches)) {
            throw new InvalidArgumentException('THERE_ARE_MANY_MINUTES');
        }
    }

    /**
     * @SuppressWarnings("UndefinedVariable")
     * @SuppressWarnings("ElseExpression")
     *
     * @param string $info
     *
     * @return void
     */
    private function handleMinutes(string $info): void
    {
        preg_match('/\d+(?!.*\d)|' . self::LIGHTNING_TALK . '/', $info, $minutesMatch);

        $minutes = Arr::first($minutesMatch);

        if (empty($minutes)) {
            throw new UnexpectedValueException('MINUTES_NOT_FOUND');
        }

        if (is_numeric($minutes)) {
            $this->minutes = (int) $minutes;
        } elseif ($minutes === self::LIGHTNING_TALK) {
            $this->minutes = self::LIGHTNING_MINUTES;
        } else {
            // @codeCoverageIgnoreStart
            throw new UnexpectedValueException('INVALID_MINUTES');
            // @codeCoverageIgnoreEnd
        }
    }

    private function existsManyNumbersInTalkTitle(array $matches): bool
    {
        return (is_array($matches) && ! empty($matches) && count($matches[0]) > 1);
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @codeCoverageIgnore
     */
    public function __set(string $name, $value): void
    {
        throw new DomainException('OBJECT_CANNOT_BE_MUTATED');
    }

    /**
     * @codeCoverageIgnore
     */
    public function __call(string $method, array $arguments): void
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s() does not exist.',
            static::class,
            $method
        ));
    }

    /**
     * @codeCoverageIgnore
     */
    public function __debugInfo(): array
    {
         return ['data' => $this->__toString()];
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString(): string
    {
        return $this->title;
    }
}
