<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\GoogleSheetSyncer;
use Illuminate\Console\Command;

class GPartialSheetSync extends Command
{
    protected $signature = 'sync:partials';

    protected $description = 'This command will sync the new data in the DB via SELECT with the Google Sheet';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(GoogleSheetSyncer $googleSheet)
    {
        $rows = User::query()
            ->select('first_name', 'last_name', 'email', 'phone')
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
