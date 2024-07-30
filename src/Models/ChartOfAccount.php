<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Ednar28\Accounting\Database\Factories\ChartOfAccountFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ChartOfAccountFactory::new();
    }

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
        return $this->directParent()->with(['parent']);
    }

    /**
     * Get a parent.
     */
    public function directParent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Get all children.
     */
    public function children(): HasMany
    {
        return $this->directChildren()->with(['children']);
    }

    /**
     * Get all children.
     */
    public function directChildren(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id')->orderBy('code');
    }
}
