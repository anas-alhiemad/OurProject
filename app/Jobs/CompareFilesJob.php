<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

class CompareFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $wordFilePath;
    protected $excelFilePath;

    /**
     * Create a new job instance.
     *
     * @param string $wordFilePath
     * @param string $excelFilePath
     */
    public function __construct(string $wordFilePath, string $excelFilePath)
    {
        $this->wordFilePath = $wordFilePath;
        $this->excelFilePath = $excelFilePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wordContent = $this->readDocx($this->wordFilePath);
        $excelContent = $this->readXlsx($this->excelFilePath);

        $similarityPercentage = $this->compareContent($wordContent, $excelContent);

        // Do something with the result, e.g., store it in the database
        // Example:
        // $result = Result::create(['similarity_percentage' => $similarityPercentage]);
    }

    private function readDocx($filePath) {
        $reader = IOFactory::load($filePath);
        return strip_tags($reader->getText());
    }

    private function readXlsx($filePath) {
        $spreadsheet = SpreadsheetIOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            if (!empty($rowData)) {
                $data[] = implode(' ', $rowData);
            }
        }

        return implode("\n", $data);
    }

    private function compareContent($contentA, $contentB) {
        similar_text($contentA, $contentB, $percent);
        return $percent;
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CompareFilesJob;

// class FileComparisonController extends Controller
// {
//     public function compare(Request $request) {
//         $wordFilePath = storage_path('app/' . $request->input('word_file'));
//         $excelFilePath = storage_path('app/' . $request->input('excel_file'));

//         // Dispatch the job
//         CompareFilesJob::dispatch($wordFilePath, $excelFilePath);

//         return response()->json([
//             'message' => 'Comparison job dispatched successfully.',
//         ]);
//     }
// }
