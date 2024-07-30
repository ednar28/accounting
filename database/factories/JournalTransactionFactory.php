<?php

namespace Ednar28\Accounting\Database\Factories;

use Ednar28\Accounting\Models\JournalTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class JournalTransactionFactory extends Factory
{
    protected $model = JournalTransaction::class;

    public function definition(): array
    {
        return [
            'modelable_id' => random_int(1, 100),
            'modelable_type' => Model::class,
            'description' => $this->faker->words(asText: true),
            'total_debit' => 0,
            'total_credit' => 0,
            'transaction_date' => $this->faker->date(),
        ];
    }
}
