<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExpenseExportController extends Controller
{
    public function export(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // عنوان‌ها
        $sheet->setCellValue('A1', 'نام کارمند');
        $sheet->setCellValue('B1', 'کد ملی');
        $sheet->setCellValue('C1', 'شماره شبا');
        $sheet->setCellValue('D1', 'بانک');
        $sheet->setCellValue('E1', 'مبلغ (ریال)');
        $sheet->setCellValue('F1', 'توضیحات');
        $sheet->setCellValue('G1', 'تاریخ تایید مالی');

        // استایل هدرها
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // داده‌ها
        $query = ExpenseRequest::with('user')
            ->where('status', 'finance_approved');

        if ($fromDate) {
            $query->whereDate('finance_approved_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('finance_approved_at', '<=', $toDate);
        }

        $expenses = $query->get();

        $row = 2;
        foreach ($expenses as $expense) {
            $sheet->setCellValue('A' . $row, $expense->user->name);
            $sheet->setCellValue('B' . $row, $expense->user->national_code);
            $sheet->setCellValue('C' . $row, $expense->user->iban);
            $sheet->setCellValue('D' . $row, $expense->user->bank_name);
            $sheet->setCellValue('E' . $row, $expense->amount);
            $sheet->setCellValue('F' . $row, $expense->description);
            $sheet->setCellValue('G' . $row, $expense->finance_approved_at->format('Y/m/d H:i'));
            $row++;
        }

        // تنظیم عرض ستون‌ها
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="expenses.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
