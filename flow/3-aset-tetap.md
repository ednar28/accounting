**Publish migrations, models**

```sh
php artisan accounting:install-fixed-assets
```

**assets**

| kolom           | type        |
| --------------- | ----------- |
| id (pk)         | bigint      |
| code            | varchar(50) |
| name            | varchar(50) |
| datetime        | datetime    |
| price           | int         |
| residu          | int         |
| residu_datetime | datetime    |
| is_depreciation | boolean     |
| created_at      | timestamp   |
| updated_at      | timestamp   |

konfigurasi untuk pembelian bisa dibuka di lokasi \config\accounting.php

```php
[
  'assets' => [
    // ...
    'account_assets' => 'Aset Tetap',
    'account_payment' => [
      'kas',
      'hutang'
    ],
    // ...
  ]
]
```

cara menambahkan aset tetap.

```php
Asset::register(
  name: 'Laptop Asus',
  price: 15_000_000,
  account_payment: 'kas',
  depreciation: [
    'is_depreciation' => true,
    'datetime' => '2024-08-01',
    'residu' => 2_000_000,
  ]
);
```
