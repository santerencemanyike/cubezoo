<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotion;
use Carbon\Carbon;

class DeactivateExpiredPromotions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotions:deactivate-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate promotions that have reached their expiry date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $expiredPromotions = Promotion::where('active', true)
                                      ->whereDate('expiry_date', '<=', $today)
                                      ->get();

        foreach ($expiredPromotions as $promotion) {
            $promotion->active = false;
            $promotion->save();
        }

        $this->info('Expired promotions have been deactivated.');
    }
}
