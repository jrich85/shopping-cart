<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\GroceryList
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read GroceryList|null $groceries
 * @method static \Database\Factories\GroceryListFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroceryList withoutTrashed()
 * @property-read int|null $groceries_count
 * @mixin \Eloquent
 */
class GroceryList extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function groceries(): HasMany
    {
        return $this->hasMany(Grocery::class);
    }

}
