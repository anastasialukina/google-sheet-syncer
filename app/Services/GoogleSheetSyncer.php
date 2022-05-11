<?php

namespace App\Services;


use Google\Service\Sheets\BatchClearValuesRequest;
use Google\Service\Sheets\ClearValuesRequest;
use Google\Service\Sheets\UpdateValuesResponse;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleSheetSyncer
{
    private $spreadSheetId;
    private $client;
    private Google_Service_Sheets $googleSheetService;

    public function __construct()
    {
        $this->spreadSheetId = config('google.post_spreadsheet_id');

        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->addScope("https://www.googleapis.com/auth/spreadsheets");

        $this->googleSheetService = new Google_Service_Sheets($this->client);
    }

    public function saveDataToSheet(array $map, $withHeader = true, $firstRow = 0): ?UpdateValuesResponse
    {
        if (count($map) == 0) {
            return null;
        }

        $data = [];

        if ($withHeader) {
            $data[] = array_keys($map[0]);
        }

        foreach ($map as $item) {
            $data[] = array_values($item);
        }

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $range = 'A' . ($firstRow + 1);


        return $this->googleSheetService
            ->spreadsheets_values
            ->update($this->spreadSheetId, $range, $body, $params);
    }
}
