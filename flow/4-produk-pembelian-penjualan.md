alur pembelian

**Publish migrations, models**

```sh
php artisan accounting:install-product
```

**products_table**

| kolom          | type         |
| -------------- | ------------ |
| id (PK)        | bigint       |
| name           | varchar(100) |
| stock          | int          |
| stock_unit     | int          |
| price_sell     | int          |
| price_purchase | int          |
| created_at     | timestamp    |
| updated_at     | timestamp    |

**purchases_table**

| kolom              | type                           |
| ------------------ | ------------------------------ |
| id (PK)            | bigint                         |
| created_by_id (FK) | bigint                         |
| status_purchase    | enum[new, canceled, completed] |
| total_bill         | int                            |
| total_payment      | int                            |
| notes              | varchar(1_000)                 |
| created_at         | timestamp                      |
| updated_at         | timestamp                      |

**purchase_items_table**

| kolom            | type        |
| ---------------- | ----------- |
| id (PK)          | bigint      |
| purchase_id (FK) | bigint      |
| product_id (FK)  | bigint      |
| name             | varchar(50) |
| qty              | int         |
| price            | int         |

**purchase_payments_table**

| kolom              | type           |
| ------------------ | -------------- |
| id (PK)            | bigint         |
| purchase_id (FK)   | bigint         |
| created_by_id (FK) | bigint         |
| notes              | varchar(1_000) |
| total              | int            |
| created_at         | timestamp      |
| updated_at         | timestamp      |

**sales**

| kolom              | type                           |
| ------------------ | ------------------------------ |
| id (PK)            | bigint                         |
| created_by_id (FK) | bigint                         |
| status_sale        | enum[new, canceled, completed] |
| total_bill         | int                            |
| total_payment      | int                            |
| notes              | varchar(1_000)                 |
| created_at         | timestamp                      |
| updated_at         | timestamp                      |

**sale_items_table**

| kolom           | type        |
| --------------- | ----------- |
| id (PK)         | bigint      |
| sale_id (FK)    | bigint      |
| product_id (FK) | bigint      |
| name            | varchar(50) |
| qty             | int         |
| price           | int         |

**sale_payments**

| kolom              | type           |
| ------------------ | -------------- |
| id (PK)            | bigint         |
| sale_id (FK)       | bigint         |
| created_by_id (FK) | bigint         |
| notes              | varchar(1_000) |
| total              | int            |
| created_at         | timestamp      |
| updated_at         | timestamp      |

konfigurasi untuk pembelian/penjualan bisa dibuka di lokasi \config\accounting.php

```php
[
  // ...
  'purchase' => [
    'account_purchase' => 'persediaan',
    'account_operating_costs' => 'biaya operasional',
    'account_payment' => [
      'kas',
      'hutang'
    ],
  ],
  'sale' => [
    'account_sale' => 'persediaan',
    'account_operating_costs' => 'biaya operasional',
    'account_discount' => 'diskon penjualan',
    'account_payment' => [
      'kas',
    ],
  ],
  // ...
]
```

<h5>Pembelian</h5>

untuk melakukan pembelian

```php
$purchase = Purchase::createTransaction(
  products: [
    [
      'product_id' => 10,
      'qty' => 10,
      'price' => 100_000,
      'status_purchase' => 'new',
    ],
  ],
  operatingCosts: 100_000,
  discount: 5_000,
  notes: 'packing kayu',
  payments: [
    [
      'account_payment' => 'gopay', // <- id nya
      'total' => 100_000,
      'notes' => 'transfer dari nomor 082230XXXXX',
    ]
  ]
);
```

untuk melakukan pembayaran pembelian

```php
$purchase = Puchase::find($id);
$purchase->createPayment(
  items: [
    [
      'account_payment' => 'gopay', // <- id nya
      'total' => 100_000,
      'notes' => 'transfer dari nomor 082230XXXXX',
    ]
  ]
);
```

untuk mendapatkan pembayaran yang tersedia.

```php
$paymentMethods = Puchase::getPurchasePaymentMethods();
```

wip retur pembelian

<h5>Penjualan</h5>

untuk melakukan penjualan

```php
$purchase = Sale::createTransaction(
  products: [
    [
      'product_id' => 10,
      'qty' => 10,
      'price' => 100_000,
      'status_sale' => 'new',
    ],
  ],
  operatingCosts: 100_000,
  discount: 5_000,
  notes: 'packing kayu',
  payments: [
    [
      'account_payment' => 'gopay', // <- id nya
      'total' => 100_000,
      'notes' => 'transfer dari nomor 082230XXXXX',
    ]
  ]
);
```

untuk melakukan pembayaran penjualan

```php
$purchase = Sale::find($id);
$purchase->createPayment(
  items: [
    [
      'account_payment' => 'gopay', // <- id nya
      'total' => 100_000,
      'notes' => 'transfer dari nomor 082230XXXXX',
    ]
  ]
);
```

wip retur penjualan
