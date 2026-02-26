<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Route;
use Throwable;
use App\Jobs\FailingLongJob;
use App\Jobs\SendMailLongJob;
use Illuminate\Bus\Batchable;

class BatchController extends Controller
{
    public function run()
    {
        $batch = Bus::batch([
            new SendMailLongJob(),
            new FailingLongJob(),
        ])->dispatch();

        return response()->json([
            'batch_id' => $batch->id
        ]);
    }

    public function progress($id)
    {
        $batch = Bus::findBatch($id);

        if (!$batch) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'total' => $batch->totalJobs,
            'pending' => $batch->pendingJobs,
            'failed' => $batch->failedJobs,
            'processed' => $batch->processedJobs(),
            'progress' => round($batch->progress()),
        ]);
    }
}