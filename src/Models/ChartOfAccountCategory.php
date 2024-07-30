<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Ednar28\Accounting\Database\Factories\ChartOfAccountCategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $normal_balance // 'debit' | 'credit'
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|ChartOfAccount[] $chartOfAccounts
 */
class ChartOfAccountCategory extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ChartOfAccountCategoryFactory::new();
    }

    /**
     * Get all chart of accounts.
     */
    public function chartOfAccounts(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}
