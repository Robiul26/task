<?php

namespace App\Jobs;

use App\Mail\ImportCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProcessCsvData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dataChunk;

    /**
     * Create a new job instance.
     *
     * @param array $dataChunk
     */
    public function __construct(array $dataChunk)
    {
        $this->dataChunk = $dataChunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->dataChunk as $row) {
            DB::table('customers')->insert([
                'branch_id' => $row['branch_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'gender' => $row['gender'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Mail::to('career@akaarit.com')->send(new ImportCompletedNotification());
       
    }
}
