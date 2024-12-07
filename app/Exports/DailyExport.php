<?php namespace App\Exports;

use App\Http\Controllers\ReportController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DailyExport extends ReportController implements FromView
{
    public function view(): View
    {
        $report = new ReportController();
        return view('report.export.daily_xl', $report->getDueData());
    }
}