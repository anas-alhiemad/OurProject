<?php

namespace App\Exports;

use App\Models\FileOperation;
use App\Models\YourModel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileOperationsExport
{
    public function export($id): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add your data to the spreadsheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'File ID');
        $sheet->setCellValue('C1', 'Operation');
        $sheet->setCellValue('D1', 'User');
        $row = 2;
        $fileOperations = DB::table('file_operations')->join('users', 'file_operations.user_id', '=', 'users.id')
            ->where('file_operations.file_id', $id)
            ->select('file_operations.*', 'users.name as name')
            ->get();
        foreach ($fileOperations as $model) {
            $sheet->setCellValue('A' . $row, $model->id);
            $sheet->setCellValue('B' . $row, $model->file_id);
            $sheet->setCellValue('C' . $row, $model->operation);
            $sheet->setCellValue('D' . $row, $model->name);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'your-model-data1.xlsx';
        $tempPath = storage_path('app/public/' . $filename);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }
}
