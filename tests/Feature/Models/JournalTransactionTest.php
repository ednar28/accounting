<?php

namespace Ednar28\Accounting\Tests\Feature\Models;

use Ednar28\Accounting\Models\ChartOfAccount;
use Ednar28\Accounting\Models\Journal;
use Ednar28\Accounting\Models\JournalTransaction;
use Ednar28\Accounting\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;

class JournalTransactionTest extends TestCase
{
    /**
     * Test a function createTransaction.
     */
    public function testCreateTransaction(): void
    {
        $description = 'pembelian';
        $transactionDate = '2024-02-01';

        JournalTransaction::createTranscation(
            $description,
            $transactionDate,
            10,
            Model::class,
        );

        $this->assertDatabaseCount('journal_transactions', 1);
        $transaction = JournalTransaction::first();
        $this->assertDatabaseHas('journal_transactions', [
            'id' => $transaction->id,
            'created_by_id' => null,
            'description' => $description,
            'transaction_date' => $transactionDate,
            'modelable_id' => 10,
            'modelable_type' => Model::class,
            'total_debit' => 0,
            'total_credit' => 0,
        ]);
    }

    /**
     * Test a function createJournals.
     */
    public function testCreateJournals(): void
    {
        /** @var JournalTransaction */
        $transaction = JournalTransaction::factory()->create();
        /** @var ChartOfAccount */
        $coa1 = ChartOfAccount::factory()->create();
        /** @var ChartOfAccount */
        $coa2 = ChartOfAccount::factory()->create();

        $journals = [
            [
                'chart_of_account_id' => $coa1->id,
                'debit' => 20_000,
                'credit' => 0,
            ],
            [
                'chart_of_account_id' => $coa2->id,
                'debit' => 0,
                'credit' => 20_000,
            ],
        ];

        $transaction->createJournals($journals);

        $this->assertDatabaseCount('journals', 2);
        [$journal1, $journal2] = Journal::get();

        $this->assertDatabaseHas('journals', [
            'id' => $journal1->id,
            'journal_transaction_id' => $transaction->id,
            'chart_of_account_id' => $journals[0]['chart_of_account_id'],
            'debit' => $journals[0]['debit'],
            'credit' => $journals[0]['credit'],
        ]);

        $this->assertDatabaseHas('journals', [
            'id' => $journal2->id,
            'journal_transaction_id' => $transaction->id,
            'chart_of_account_id' => $journals[1]['chart_of_account_id'],
            'debit' => $journals[1]['debit'],
            'credit' => $journals[1]['credit'],
        ]);
    }
}
