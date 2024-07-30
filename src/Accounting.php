<?php

namespace Ednar28\Accounting;

use Ednar28\Accounting\Models\InitialBalance;
use Ednar28\Accounting\Models\JournalTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accounting
{
    /**
     * Create initial balance.
     *
     * @param array<int, array{debit: int, credit: int, chart_of_account_id: int}> $data
     */
    public function createInitialBalance(array $data)
    {
        DB::transaction(function () use ($data) {
            foreach ($data as $initialBalanceData) {
                InitialBalance::updateOrCreate(
                    ['chart_of_account_id' => $initialBalanceData['chart_of_account_id']],
                    ['debit' => $initialBalanceData['debit'], 'credit' => $initialBalanceData['credit']],
                );
            }
        });
    }

    /**
     * Create a jurnal transaction.
     *
     * @param array{model: Model, description: string, transaction_date: string, journals: array<int, array{chart_of_account_id: int, debit: int, credit: int}>} $data
     */
    public function createJournalTransaction(array $data): JournalTransaction
    {
        return DB::transaction(function () use ($data) {
            $transaction = JournalTransaction::createTranscation(
                $data['description'],
                $data['transaction_date'],
                $data['model']->id,
                $data['model']->getMorphClass(),
            );

            $transaction->createJournals($data['journals']);

            $transaction->calculateTotalDebit();
            $transaction->calculateTotalCredit();

            if ($transaction->total_debit !== $transaction->total_credit) {
                throw new \ErrorException('value total debit and total credit not same.');
            }
            $transaction->save();

            return $transaction;
        });
    }
}
