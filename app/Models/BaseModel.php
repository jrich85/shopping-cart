<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    use HasUuids;

    public string $id;

    protected static function booted(): void
    {
        static::saving(function (BaseModel $model) {
            $model->setAttribute('id', Str::uuid()->toString());
        });
    }
}
