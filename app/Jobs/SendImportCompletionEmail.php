<?php

namespace App\Jobs;


use App\Mail\ImportCompletedNotification;
use Illuminate\Support\Facades\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendImportCompletionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $batchesCount;

    public function __construct($batchesCount)
    {
        $this->batchesCount = $batchesCount;
    }

    public function handle()
    {
        // Poll the job queue to ensure all batch jobs are processed
        while ($this->pendingBatches()) {
            sleep(5); // Wait before checking again
        }

        // Send the email
        Mail::to('career@akaarit.com')->send(new ImportCompletedNotification());
    }

    private function pendingBatches()
    {
        return \DB::table('jobs')->where('payload', 'like', '%ProcessCsvData%')->count() > 0;
    }
}
