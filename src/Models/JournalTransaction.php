<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $modelable_id
 * @property string $modelable_type
 * @property string $description
 * @property int $total_debit
 * @property int $total_credit
 * @property string $transaction_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Journal[] $journals
 */
class JournalTransaction extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_debit' => 'int',
            'total_credit' => 'int',
        ];
    }

    /**
     * Get all journals.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
