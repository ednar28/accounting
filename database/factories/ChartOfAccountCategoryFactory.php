<?php

namespace Ednar28\Accounting\Database\Factories;

use Ednar28\Accounting\Models\ChartOfAccountCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartOfAccountCategoryFactory extends Factory
{
    protected $model = ChartOfAccountCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(random_int(1, 2), true),
            'normal_balance' => $this->faker->randomElement(['debit', 'credit']),
        ];
    }
}
