<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Chart of account categories
    |--------------------------------------------------------------------------
    | upcoming
    */
    'coa_categories' => [
        'Aset' => 'debit',
        'Liabilitas' => 'credit',
        'Ekuitas' => 'credit',
        'Pendapatan' => 'credit',
        'Biaya' => 'debit',
    ],

    /*
  |--------------------------------------------------------------------------
  | Chart of account
  |--------------------------------------------------------------------------
  | upcoming
  */
    'coa' => [
        [
            'coa_category' => 'Aset',
            'coa' => [
                [
                    'name' => 'Kas',
                    'code' => '1-10001',
                ],
                [
                    'name' => 'Piutang',
                    'code' => '1-10002',
                ],
            ],
        ],
        [
            'coa_category' => 'Liabilitas',
            'coa' => [
                [
                    'name' => 'Hutang Bank',
                    'code' => '2-20001',
                ],
            ],
        ],
        [
            'coa_category' => 'Ekuitas',
            'coa' => [
                [
                    'name' => 'Modal',
                    'code' => '3-30001',
                ],
                [
                    'name' => 'Laba Ditahan',
                    'code' => '3-30002',
                ],
            ],
        ],
        [
            'coa_category' => 'Pendapatan',
            'coa' => [
                [
                    'name' => 'Pendapatan Jasa',
                    'code' => '4-40001',
                ],
            ],
        ],
        [
            'coa_category' => 'Biaya',
            'coa' => [
                [
                    'name' => 'Biaya Listrik',
                    'code' => '5-50001',
                ],
            ],
        ],
    ],
];
