<?php

namespace Support\ORM;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Save model to the database using transaction without running any events.
     *
     * @param array $options
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function saveQuietly(array $options = []): bool
    {
        return static::withoutEvents(function () use ($options): bool {
            return $this->saveOrFail($options);
        });
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Support\ORM\BaseCollection
     */
    public function newCollection(array $models = []): BaseCollection
    {
        return new BaseCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Support\ORM\BaseEloquentBuilder
     */
    public function newEloquentBuilder($query): BaseEloquentBuilder
    {
        return new BaseEloquentBuilder($query);
    }

    /**
     * Begin querying the model.
     *
     * @return \Support\ORM\BaseEloquentBuilder
     */
    public static function query(): BaseEloquentBuilder
    {
        return parent::query();
    }
}
