<?php

namespace App\Console\Commands;

use App\Models\TimeEntry;
use App\Services\GoogleSheetSyncer;
use Illuminate\Console\Command;

class GSheetSync extends Command
{
    protected $signature = 'sync:entries';

    protected $description = 'This command will sync the new data in the DB with the Google Sheet';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(GoogleSheetSyncer $googleSheet)
    {
        $rows = TimeEntry::query()
            ->orderBy('id')
            ->limit(10000)
            ->get();

        if ($rows->count() === 0) {
            return true;
        }

        $googleSheet->saveDataToSheet($rows->toArray());

        return true;
    }
}
