contoh pembuatan jurnal transaksi untuk jasa
Pada tanggal 1 Juli 2023, Bapak Dwi Sasongko menyetorkan modal perusahaan sebesar Rp250.000.000.

```php
  $accounting = new Accounting();
  $accounting->createJournalTransaction([
    'description' => 'Bapak Dwi Sasongko setor modal',
    'journals' => [
      [
        'chart_of_account' => Account::find('kas')->id,
        'debit' => 250_000_000,
      ],
      [
        'chart_of_account' => Account::find('modal')->id,
        'credit' => 250_000_000,
      ],
    ]
  ])

```

cara mendapatkan list journal transaksi

```php

```
