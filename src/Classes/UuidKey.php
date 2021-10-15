<?php

namespace Caiocesar173\Aprobank\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * Trait HasUuid
 */
trait UuidKey
{
    protected $isLockedUuid = true;

    /**
     * Used by Eloquent to get primary key type.
     * UUID Identified as a string.
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Used by Eloquent to get if the primary key is auto increment value.
     * UUID is not.
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Add behavior to creating and saving Eloquent events.
     * @return void
     */
    public static function bootUuidKey()
    {
        // Create a UUID to the model if it does not have one
        static::creating(function (Model $model) {
            $model->keyType = 'string';
            $model->incrementing = false;

            if (!$model->getKey()) {
                $uuid = Uuid::uuid4();
                $model->{$model->getKeyName()} = $uuid->toString();
            }
        });

        // Set original if someone try to change UUID on update/save existing model
        static::saving(function (Model $model) {
            $original_id = $model->getOriginal('id');
            if (!is_null($original_id) && $model->isLockedUuid) {
                if ($original_id !== $model->id) {
                    $model->id = $original_id;
                }
            }
        });
    }
}