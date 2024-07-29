<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $normal_balance // 'debit' | 'credit'
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ChartOfAccountCategory extends Model
{
    // do something
}
