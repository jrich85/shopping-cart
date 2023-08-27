<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Grocery
 *
 * @property int $id
 * @property string $name
 * @property string $grocery_list_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\GroceryList $groceryList
 * @method static \Database\Factories\GroceryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereGroceryListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Grocery withoutTrashed()
 * @mixin \Eloquent
 */
class Grocery extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'grocery_list_id',
    ];

    public function groceryList(): BelongsTo
    {
        return $this->belongsTo(GroceryList::class);
    }
}
