<?php

namespace App\API\Conference\Entity;

use Throwable;
use Ds\Hashable;
use Carbon\Carbon;
use DomainException;
use Illuminate\Support\Arr;
use App\API\Conference\ValueObjects\TalkInfo;
use App\API\Conference\Entity\Concerns\StartTime;

final class Talk implements Hashable
{
    use StartTime;

    private string $key;
    private string $title;
    private Carbon $startTime;
    private int $durationInMinutes;

    public function __construct(string $title)
    {
        $talkInfo = app(TalkInfo::class, ['info' => $title]);
        $this->title = $talkInfo->title();
        $this->durationInMinutes = $talkInfo->minutes();

        $this->key = hash('sha256', $this->title);
    }

    public function key(): string
    {
        return $this->key;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function durationInMinutes(): int
    {
        return $this->durationInMinutes;
    }

    /**
     * @SuppressWarnings(PHPMD)
     *
     * @param \Carbon\Carbon|null $newStartTime
     *
     * @return \Carbon\Carbon
     */
    public function startTime(?Carbon $newStartTime = null): Carbon
    {
        try {
            $this->startTime;
        } catch (Throwable $exception) {
            preg_match('/must not be accessed before initialization/m', $exception->getMessage(), $matches);

            $propertyUninitialized = ! empty(Arr::first(Arr::wrap($matches)));

            // @codeCoverageIgnoreStart
            if (! is_null($newStartTime) && $propertyUninitialized) {
                $this->startTime = $newStartTime;
            } elseif ($propertyUninitialized) {
                throw new DomainException('Talk start date was not specified.');
            } else {
                throw $exception;
            }
            // @codeCoverageIgnoreEnd
        } finally {
            //
        }

        return $this->startTime;
    }

    /**
     * Should return the same value for all equal objects, but doesn't have to
     * be unique. This value will not be used to determine equality.
     *
     * @return mixed
     */
    public function hash()
    {
        return $this->title;
    }

    /**
     * This determines equality, usually during a hash table lookup to determine
     * if the bucket's key matches the lookup key. The hash has to be equal if
     * the objects are equal, otherwise this determination wouldn't be reached.
     *
     * @param object $obj
     *
     * @return bool
     */
    public function equals($obj): bool
    {
        return hash_equals($this->key(), $obj->key());
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
