<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $parent_id
 * @property int $chart_of_account_category_id
 * @property string $name
 * @property string $code
 * @property string $period
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read ChartOfAccountCategory $category
 * @property-read ChartOfAccount $parent
 * @property-read Collection|ChartOfAccount[] $children
 */
class ChartOfAccount extends Model
{
    /**
     * Get a category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccountCategory::class);
    }

    /**
     * Get a parent.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Get all children.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }
}
