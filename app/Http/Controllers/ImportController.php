<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessCsvData;
use App\Jobs\SendImportCompletionEmail;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('import'); // Render the HTML form
    }

    public function importCsv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required',
        ]);

        // Store the uploaded file
        $filePath = $request->file('csv_file')->store('imports');

         // Read and process the file
        if (($handle = fopen(storage_path("app/private/{$filePath}"), "r")) !== false) {
            $header = null;
            $batch = []; // Temporary array for batch processing
            $batchSize = 100; // Number of rows per batch
            $batchesCount = 0; // Track number of dispatched batches

            while (($row = fgetcsv($handle, 500, ",")) !== false) {
                if (!$header) {
                    $header = $row; // Store header row
                } else {
                    // Combine header and row into an associative array
                    $data = array_combine($header, $row);
                    // Add row to batch
                    $batch[] = $data;

                    // Dispatch the batch if it reaches the size
                    if (count($batch) >= $batchSize) {
                        ProcessCsvData::dispatch($batch);
                        $batchesCount++; // Increment batch count
                        $batch = []; // Reset batch
                    }
                }
            }

            // Dispatch remaining rows
            if (!empty($batch)) {
                ProcessCsvData::dispatch($batch);
                $batchesCount++; // Increment batch count
            }

            fclose($handle);

            // Use a job to send the email after a delay to ensure all batches are processed
            SendImportCompletionEmail::dispatch($batchesCount)->delay(30); // Add delay to ensure jobs finish
        }

        return back()->with('success', 'CSV imported successfully!');
    }
}
