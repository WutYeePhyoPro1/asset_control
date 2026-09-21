<?php

namespace App\Console\Commands;

use App\Models\AssetHistory;
use App\Models\FixAsset;
use Illuminate\Console\Command;

class SyncAssetHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:sync-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync asset history from server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        syncAssetHistory();
        $this->info('Asset history synced successfully');
    }
}
