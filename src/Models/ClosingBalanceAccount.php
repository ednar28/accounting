<?php

namespace Ednar28\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $closing_balance_id
 * @property int $balance
 */
class ClosingBalanceAccount extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'balance' => 'int',
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
