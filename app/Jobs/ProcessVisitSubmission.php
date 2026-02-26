<?php

namespace App\Jobs;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessVisitSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $visit;

    /**
     * Create a new job instance.
     *
     * @param Visit $visit
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Simulate external call
        Log::info("Processing visit submission for visit ID: {$this->visit->id}");

        // Record the event
        $this->visit->events()->create([
            'event' => 'submitted_processed',
        ]);
    }
}
