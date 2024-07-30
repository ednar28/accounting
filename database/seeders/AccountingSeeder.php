<?php

namespace Ednar28\Accounting\Seeders;

use Ednar28\Accounting\Models\ChartOfAccount;
use Ednar28\Accounting\Models\ChartOfAccountCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class AccountingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedCoaCategories();

        $this->seedCoa();
    }

    /**
     * Create seeder categories.
     */
    private function seedCoaCategories(): void
    {
        /** @var array<string, string> */
        $categories = config('accounting.seeder_coa_categories', []);

        foreach ($categories as $name => $normalBalance) {
            $coaCategory = new ChartOfAccountCategory();
            $coaCategory->name = $name;
            $coaCategory->normal_balance = $normalBalance;
            $coaCategory->save();
        }
    }

    /**
     * Create seeder coa.
     */
    private function seedCoa(): void
    {
        /** @var array<int, array{coa_category: string, coa: array<int, array{name: string, code: string}>}> */
        $allData = config('accounting.seeder_coa', []);

        /** @var Collection */
        $categories = ChartOfAccountCategory::get();

        foreach ($allData as $data) {
            /** @var ChartOfAccountCategory */
            $category = $categories->firstWhere('name', $data['coa_category']);

            $chartOfAccounts = [];
            foreach ($data['coa'] as $coa) {
                $chartOfAccount = new ChartOfAccount();
                $chartOfAccount->name = $coa['name'];
                $chartOfAccount->code = $coa['code'];
                $chartOfAccounts[] = $chartOfAccount;
            }

            $category->chartOfAccounts()->saveMany($chartOfAccounts);
        }
    }
}
