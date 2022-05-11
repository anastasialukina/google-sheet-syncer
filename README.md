# google-sheet-syncer

Sync DB with Google Sheet via commands

## Command usage

To synchronize manually enter a command:

`php artisan sync:users`

To start synchronization every 2 minutes automatically:

1. Open your crontab `crontab -e`
2. Add the next line to the end:

```
*/2 * * * * php /path/to/project/artisan sync:users
```

_(I know about command scheduling in the Kernel.php, but you said about crontab :) )_

## Code usage

GoogleSheetSyncer service has the following abilities:

* Write data to sheet via function saveDataToSheet(**array $map**) directly from map
* Write data (specific columns) without headers via parameter saveDataToSheet(array $map, **$withHeader = false**)
* Write data with shift (5) via parameter saveDataToSheet(array $map, $withHeader = true, **$firstRow = 5**)

To create or edit existing command and update and synchronize only specific columns you should follow example in already
existing command `php artisan sync:partials`

Use **select** to specify the columns you need to see in the Google Sheet table.

For example to select columns 'first_name', 'last_name', 'email', 'phone' use the following line:

```
$rows = User::query()
    ->select('first_name', 'last_name', 'email', 'phone')
    ->orderBy('id')
    ->limit(10000)
    ->get();
```

Also, you can edit (and then use) a command
`php artisan sync:entries` to manipulate another table/s.

By default, it adds a table 'entries' created for tests.


