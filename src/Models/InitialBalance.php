<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $chart_of_account_id
 * @property int $debit
 * @property int $credit
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read ChartOfAccount $chartOfAccount
 */
class InitialBalance extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'debit' => 'int',
            'credit' => 'int',
        ];
    }

    /**
     * Get a chart of account.
     */
    public function chartOfAccount(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
