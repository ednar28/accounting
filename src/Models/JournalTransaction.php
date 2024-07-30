<?php

namespace Ednar28\Accounting\Models;

use Carbon\Carbon;
use Ednar28\Accounting\Database\Factories\JournalTransactionFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

/**
 * @property int $id
 * @property int|null $created_by_id
 * @property int $modelable_id
 * @property string $modelable_type
 * @property string $description
 * @property int $total_debit
 * @property int $total_credit
 * @property string $transaction_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Journal[] $journals
 * @property-read User|null $createdBy
 */
class JournalTransaction extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return JournalTransactionFactory::new();
    }

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
     * Get who's create this transaction.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get all journals.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Create a transaction.
     */
    public static function createTranscation(
        string $description,
        string $transactionDate,
        int $modelableId,
        string $modelableType,
    ): JournalTransaction {
        $transaction = new JournalTransaction();
        $transaction->createdBy()->associate(auth()->user());
        $transaction->description = $description;
        $transaction->transaction_date = $transactionDate;
        $transaction->modelable_id = $modelableId;
        $transaction->modelable_type = $modelableType;
        $transaction->save();

        return $transaction;
    }

    /**
     * Create all journals.
     *
     * @param array<int, array{chart_of_account_id: int, debit: int, credit: int}> $data
     */
    public function createJournals($data): void
    {
        $journals = [];
        foreach ($data as $dataJournal) {
            $journal = new Journal();
            $journal->chart_of_account_id = $dataJournal['chart_of_account_id'];
            $journal->debit = $dataJournal['debit'];
            $journal->credit = $dataJournal['credit'];
            $journals[] = $journal;
        }

        $this->journals()->saveMany($journals);
    }

    /**
     * Calculate total debit.
     */
    public function calculateTotalDebit(): void
    {
        $totalDebit = $this->journals->reduce(fn ($carry, Journal $journal) => $carry + $journal->debit, 0);
        $this->total_debit = $totalDebit;
    }

    /**
     * Calculate total credit.
     */
    public function calculateTotalCredit(): void
    {
        $totalCredit = $this->journals->reduce(fn ($carry, Journal $journal) => $carry + $journal->credit, 0);
        $this->total_credit = $totalCredit;
    }
}
