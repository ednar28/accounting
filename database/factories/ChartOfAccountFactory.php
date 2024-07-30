<?php

namespace Ednar28\Accounting\Database\Factories;

use Ednar28\Accounting\Models\ChartOfAccount;
use Ednar28\Accounting\Models\ChartOfAccountCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartOfAccountFactory extends Factory
{
    protected $model = ChartOfAccount::class;

    public function definition(): array
    {
        return [
            'chart_of_account_category_id' => ChartOfAccountCategory::factory(),
            'name' => $this->faker->words(random_int(1, 2), true),
            'code' => $this->faker->numerify('#-####'),
            'period' => null,
        ];
    }
}
