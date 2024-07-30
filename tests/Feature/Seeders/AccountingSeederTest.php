<?php

namespace Ednar28\Accounting\Tests\Feature\Seeders;

use Ednar28\Accounting\Models\ChartOfAccount;
use Ednar28\Accounting\Models\ChartOfAccountCategory;
use Ednar28\Accounting\Seeders\AccountingSeeder;
use Ednar28\Accounting\Tests\TestCase;

class AccountingSeederTest extends TestCase
{
    public function testRun(): void
    {
        config([
            'accounting.seeder_coa_categories' => ['aset' => 'debit'],
        ]);

        config([
            'accounting.seeder_coa' => [
                [
                    'coa_category' => 'aset',
                    'coa' => [
                        [
                            'name' => 'kas',
                            'code' => '1-10001',
                        ],
                    ],
                ],
            ],
        ]);

        $this->seed(AccountingSeeder::class);

        $this->assertDatabaseCount('chart_of_account_categories', 1);
        $category = ChartOfAccountCategory::first();
        $this->assertDatabaseHas('chart_of_account_categories', [
            'id' => $category->id,
            'name' => 'aset',
            'normal_balance' => 'debit',
        ]);

        $this->assertDatabaseCount('chart_of_accounts', 1);
        $coa = ChartOfAccount::first();
        $this->assertDatabaseHas('chart_of_accounts', [
            'id' => $coa->id,
            'parent_id' => null,
            'chart_of_account_category_id' => $category->id,
            'name' => 'kas',
            'code' => '1-10001',
            'period' => null,
        ]);
    }
}
