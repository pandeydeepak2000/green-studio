<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GstReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected int $companyId;
    protected ?string $fromDate;
    protected ?string $toDate;

    public function __construct(int $companyId, ?string $fromDate = null, ?string $toDate = null)
    {
        $this->companyId = $companyId;
        $this->fromDate  = $fromDate;
        $this->toDate    = $toDate;
    }

    public function collection(): Collection
    {
        $query = Invoice::with(['customer', 'company'])
            ->where('company_id', $this->companyId);

        if ($this->fromDate) {
            $query->whereDate('invoice_date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('invoice_date', '<=', $this->toDate);
        }

        // Agar sirf paid invoices chahiye:
        // $query->where('status', 'paid');

        return $query->orderBy('invoice_date')->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Type',
            'Date',
            'Bill No',
            'State Name',
            'GST Number',
            'Rate (GST %)',
            'Sale Type',
            'Taxable value',
            'IGST',
            'CGST',
            'SGST',
            'Total Bill Value',
        ];
    }

    public function map($invoice): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $customer = $invoice->customer;

        // Simple assumption: sab items same GST % par; ya tum avg/first le sakte ho
        $gstPercent = optional($invoice->items->first())->gst_percent ?? 0;

        return [
            $rowNumber,
            'Sale',
            optional($invoice->invoice_date)->format('d-M-y'),
            $invoice->invoice_number,
            $customer->state ?? '',
            $customer->gst_number ?? '',
            $gstPercent . '%',
            $invoice->sale_type ?? '',
            (float) $invoice->taxable_amount,
            (float) $invoice->igst_amount,
            (float) $invoice->cgst_amount,
            (float) $invoice->sgst_amount,
            (float) $invoice->total_amount,
        ];
    }

    public function title(): string
    {
        return 'GST Report';
    }
}