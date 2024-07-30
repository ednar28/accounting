<?php

namespace Ednar28\Accounting\Tests\Feature;

use Ednar28\Accounting\Accounting;
use Ednar28\Accounting\Models\ChartOfAccount;
use Ednar28\Accounting\Models\InitialBalance;
use Ednar28\Accounting\Models\Journal;
use Ednar28\Accounting\Models\JournalTransaction;
use Ednar28\Accounting\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;

class AccountingTest extends TestCase
{
    /**
     * Test a function createInitialBalance.
     */
    public function testCreateInitialBalance(): void
    {
        $accounting = new Accounting();

        [$coa1, $coa2] = ChartOfAccount::factory()->count(2)->create();

        // test create
        $data1 = [
            ['chart_of_account_id' => $coa1->id, 'debit' => 100_000, 'credit' => 0],
            ['chart_of_account_id' => $coa2->id, 'debit' => 0, 'credit' => 100_000],
        ];
        $accounting->createInitialBalance($data1);

        $this->assertDatabaseCount('initial_balances', 2);
        [$initialBalance1, $initialBalance2] = InitialBalance::get();

        $this->assertDatabaseHas('initial_balances', [
            'id' => $initialBalance1->id,
            'chart_of_account_id' => $data1[0]['chart_of_account_id'],
            'debit' => $data1[0]['debit'],
            'credit' => $data1[0]['credit'],
        ]);
        $this->assertDatabaseHas('initial_balances', [
            'id' => $initialBalance2->id,
            'chart_of_account_id' => $data1[1]['chart_of_account_id'],
            'debit' => $data1[1]['debit'],
            'credit' => $data1[1]['credit'],
        ]);

        // test update
        $data2 = [
            ['chart_of_account_id' => $coa2->id, 'debit' => 0, 'credit' => 200_000],
            ['chart_of_account_id' => $coa1->id, 'debit' => 200_000, 'credit' => 0],
        ];
        $accounting->createInitialBalance($data2);

        $this->assertDatabaseCount('initial_balances', 2);

        $this->assertDatabaseHas('initial_balances', [
            'id' => $initialBalance1->id,
            'chart_of_account_id' => $data2[1]['chart_of_account_id'],
            'debit' => $data2[1]['debit'],
            'credit' => $data2[1]['credit'],
        ]);
        $this->assertDatabaseHas('initial_balances', [
            'id' => $initialBalance2->id,
            'chart_of_account_id' => $data2[0]['chart_of_account_id'],
            'debit' => $data2[0]['debit'],
            'credit' => $data2[0]['credit'],
        ]);
    }

    /**
     * Test a function createJournalTransaction.
     */
    public function testCreateJournalTransaction(): void
    {
        $accounting = new Accounting();

        $modelFake = new class() {
            public int $id = 1;

            public function getMorphClass(): string
            {
                return Model::class;
            }
        };
        [$aset, $modal] = ChartOfAccount::factory()->count(2)->create();

        $data = [
            'description' => 'pembelian aset',
            'transaction_date' => now()->format('Y-m-d'),
            'model' => $modelFake,
            'journals' => [
                [
                    'chart_of_account_id' => $aset->id,
                    'debit' => 1_250_000,
                    'credit' => 0,
                ],
                [
                    'chart_of_account_id' => $modal->id,
                    'debit' => 0,
                    'credit' => 1_250_000,
                ],
            ],
        ];

        $accounting->createJournalTransaction($data);

        $this->assertDatabaseCount('journal_transactions', 1);
        $transaction = JournalTransaction::first();
        $this->assertDatabaseHas('journal_transactions', [
            'id' => $transaction->id,
            'description' => $data['description'],
            'transaction_date' => $data['transaction_date'],
            'modelable_id' => 1,
            'modelable_type' => Model::class,
            'total_debit' => 1_250_000,
            'total_credit' => 1_250_000,
        ]);

        $this->assertDatabaseCount('journals', 2);
        [$journal1, $journal2] = Journal::get();
        $this->assertDatabaseHas('journals', [
            'id' => $journal1->id,
            'journal_transaction_id' => $transaction->id,
            'chart_of_account_id' => $data['journals'][0]['chart_of_account_id'],
            'debit' => $data['journals'][0]['debit'],
            'credit' => $data['journals'][0]['credit'],
        ]);
        $this->assertDatabaseHas('journals', [
            'id' => $journal2->id,
            'journal_transaction_id' => $transaction->id,
            'chart_of_account_id' => $data['journals'][1]['chart_of_account_id'],
            'debit' => $data['journals'][1]['debit'],
            'credit' => $data['journals'][1]['credit'],
        ]);
    }
}
