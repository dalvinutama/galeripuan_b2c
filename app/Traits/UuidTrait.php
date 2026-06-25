<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait // <-- Pastikan namanya UuidTrait
{
    protected static function bootUuidTrait() // <-- Pastikan namanya bootUuidTrait
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}