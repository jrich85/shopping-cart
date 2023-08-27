<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * BaseModel
 *
 * @property string $id
 */
class BaseModel extends Model
{
    use HasUuids;

    protected static function booted(): void
    {
        static::creating(function (BaseModel $model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
