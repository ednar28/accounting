<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $jurnal_transaction_id
 * @property int $chart_of_accouunt_id
 * @property int $debit
 * @property int $credit
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read JournalTransaction $transaction
 */
class Journal extends Model
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
     * Get a transaction.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(JournalTransaction::class);
    }
}
