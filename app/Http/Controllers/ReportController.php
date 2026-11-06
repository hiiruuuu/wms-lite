<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $mutations = StockMutation::with(['product', 'user', 'supplier'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.stock_mutation_pdf', compact('mutations', 'startDate', 'endDate'));
        
        return $pdf->download("Laporan-Mutasi-Stok-{$startDate}-sd-{$endDate}.pdf");
    }
}
