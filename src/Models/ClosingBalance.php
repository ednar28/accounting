<?php

namespace Ednar28\Accounting\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $created_by_id
 * @property string $period
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $createdBy
 */
class ClosingBalance extends Model
{
    /**
     * Get who's created this closing balance.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
