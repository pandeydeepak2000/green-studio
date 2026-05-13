<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GstReportExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GstReportController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();

        $companyId = $request->get('company_id');
        $from      = $request->get('from');
        $to        = $request->get('to');

        $summary = null;

        if ($companyId) {
            $query = Invoice::where('company_id', $companyId);

            if ($from) {
                $query->whereDate('invoice_date', '>=', $from);
            }

            if ($to) {
                $query->whereDate('invoice_date', '<=', $to);
            }

            // Agar sirf PAID invoices chahiye to yahan filter kar sakte ho:
            // $query->where('status', 'paid');

            $summary = [
                'count'          => (clone $query)->count(),
                'taxable_amount' => (clone $query)->sum('taxable_amount'),
                'cgst_amount'    => (clone $query)->sum('cgst_amount'),
                'sgst_amount'    => (clone $query)->sum('sgst_amount'),
                'igst_amount'    => (clone $query)->sum('igst_amount'),
                'total_amount'   => (clone $query)->sum('total_amount'),
            ];
        }

        return view('admin.gst-reports.index', [
            'companies'  => $companies,
            'company_id' => $companyId,
            'from'       => $from,
            'to'         => $to,
            'summary'    => $summary,
        ]);
    }

    public function download(Request $request)
    {
        $data = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'from'       => ['nullable', 'date'],
            'to'         => ['nullable', 'date'],
        ]);

        $fileName = 'gst-report-' . now()->format('Y-m-d_H-i') . '.xlsx';

        return Excel::download(
            new GstReportExport($data['company_id'], $data['from'] ?? null, $data['to'] ?? null),
            $fileName
        );
    }
}