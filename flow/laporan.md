cara mendapatkan data buku besar

```php
$accounts = Accounting::ledger(
  startFrom: now()->subDays(30)->format('Y-m-d'),
  endTo: now()->format('Y-m-d'),
);
```
