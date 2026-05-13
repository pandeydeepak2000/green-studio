<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceTransaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        // date sort
        $sort = $request->get('sort', 'newest');

        if ($sort === 'oldest') {

            $query->orderBy('invoice_date', 'asc');

        } else {

            $query->orderBy('invoice_date', 'desc');

        }

        // search
        if ($search = $request->get('q')) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'invoice_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'customer',
                    function ($qc) use ($search) {

                        $qc->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'company_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        );

                    }
                );

            });

        }

        // date range
        if ($from = $request->get('from')) {

            $query->whereDate(
                'invoice_date',
                '>=',
                $from
            );

        }

        if ($to = $request->get('to')) {

            $query->whereDate(
                'invoice_date',
                '<=',
                $to
            );

        }

        // status filter
        $status = $request->get('status');

        if ($status) {

            $query->where('status', $status);

        }

        $invoices = $query->paginate(15);

        return view('staff.invoices.index', [

            'invoices' => $invoices,
            'search'   => $search ?? null,
            'from'     => $from ?? null,
            'to'       => $to ?? null,
            'sort'     => $sort,
            'status'   => $status,

        ]);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(
            'company',
            'customer',
            'items',
            'transactions'
        );

        return view(
            'staff.invoices.show',
            compact('invoice')
        );
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        $company = $user->company;

        if (!$company) {

            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'status',
                    'No company assigned to your account. Please contact admin.'
                );

        }

        // customer search
        $customerSearch = $request->get('customer_q');

        $customers = Customer::when(
                $customerSearch,
                function ($q) use ($customerSearch) {

                    $q->where(
                        'name',
                        'like',
                        "%{$customerSearch}%"
                    )

                    ->orWhere(
                        'company_name',
                        'like',
                        "%{$customerSearch}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$customerSearch}%"
                    );

                }
            )
            ->orderBy('name')
            ->limit(50)
            ->get();

        return view(
            'staff.invoices.create',
            compact(
                'company',
                'customers',
                'customerSearch'
            )
        );
    }

    public function store(Request $request)
    {
        $company = auth()->user()->company;

        if (!$company) {

            abort(
                403,
                'No company assigned to your account.'
            );

        }

        $data = $request->validate([

            'invoice_number' => [
                'required',
                'string',
                'max:100',
                'unique:invoices,invoice_number'
            ],

            'customer_id' => [
                'required',
                'exists:customers,id'
            ],

            'invoice_date' => [
                'required',
                'date'
            ],

        ]);

        $customer = Customer::findOrFail(
            $data['customer_id']
        );

        $saleType = null;

        if ($company->state && $customer->state) {

            $saleType = (
                $company->state === $customer->state
            )
                ? 'LOCAL'
                : 'CENTRAL';

        }

        $invoice = Invoice::create([

            'invoice_number' => $data['invoice_number'],
            'invoice_date'   => $data['invoice_date'],
            'company_id'     => $company->id,
            'customer_id'    => $customer->id,
            'sale_type'      => $saleType,
            'taxable_amount' => 0,
            'cgst_amount'    => 0,
            'sgst_amount'    => 0,
            'igst_amount'    => 0,
            'total_amount'   => 0,
            'status'         => 'unpaid',

        ]);

        // ACTIVITY LOG
        ActivityLog::create([

            'user_id'     => auth()->id(),
            'action'      => 'create',
            'module'      => 'invoice',
            'module_id'   => $invoice->id,
            'description' => 'Created invoice #' . $invoice->invoice_number,

        ]);

        return redirect()
            ->route('staff.invoices.edit', $invoice)
            ->with(
                'status',
                'Invoice created, now add items.'
            );
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(
            'items',
            'customer',
            'company',
            'transactions'
        );

        return view(
            'staff.invoices.edit',
            compact('invoice')
        );
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {

            return redirect()
                ->route('staff.invoices.index')
                ->with(
                    'status',
                    'No invoices selected.'
                );

        }

        $companyId = auth()->user()->company_id;

        Invoice::whereIn('id', $ids)
            ->when(
                $companyId,
                function ($q) use ($companyId) {

                    $q->where(
                        'company_id',
                        $companyId
                    );

                }
            )
            ->delete();

        return redirect()
            ->route('staff.invoices.index')
            ->with(
                'status',
                'Selected invoices deleted.'
            );
    }

    public function updateItems(
        Request $request,
        Invoice $invoice
    ) {
        $data = $request->validate([

            'items'               => ['array'],

            'items.*.description' => [
                'required',
                'string',
                'max:255'
            ],

            'items.*.rate' => [
                'required',
                'numeric',
                'min:0'
            ],

            'items.*.gst_percent' => [
                'required',
                'numeric',
                'min:0'
            ],

        ]);

        $invoice->items()->delete();

        $taxableTotal = 0;
        $cgstTotal = 0;
        $sgstTotal = 0;
        $igstTotal = 0;
        $grandTotal = 0;

        foreach ($data['items'] as $itemData) {

            $rate = $itemData['rate'];

            $taxRate = $itemData['gst_percent'];

            $lineTaxable = $rate;

            $gstAmount = $lineTaxable * ($taxRate / 100);

            $cgst = 0;
            $sgst = 0;
            $igst = 0;

            if ($invoice->sale_type === 'LOCAL') {

                $cgst = $gstAmount / 2;
                $sgst = $gstAmount / 2;

            } elseif ($invoice->sale_type === 'CENTRAL') {

                $igst = $gstAmount;

            }

            $lineTotal = $lineTaxable + $gstAmount;

            $invoice->items()->create([

                'description' => $itemData['description'],
                'rate' => $rate,
                'taxable' => $lineTaxable,
                'gst_percent' => $taxRate,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'line_total' => $lineTotal,

            ]);

            $taxableTotal += $lineTaxable;
            $cgstTotal += $cgst;
            $sgstTotal += $sgst;
            $igstTotal += $igst;
            $grandTotal += $lineTotal;
        }

        $invoice->update([

            'taxable_amount' => $taxableTotal,
            'cgst_amount'    => $cgstTotal,
            'sgst_amount'    => $sgstTotal,
            'igst_amount'    => $igstTotal,
            'total_amount'   => $grandTotal,

        ]);

        // ACTIVITY LOG
        ActivityLog::create([

            'user_id'     => auth()->id(),
            'action'      => 'update',
            'module'      => 'invoice',
            'module_id'   => $invoice->id,
            'description' => 'Updated invoice #' . $invoice->invoice_number,

        ]);

        return redirect()
            ->route('staff.invoices.edit', $invoice)
            ->with(
                'status',
                'Items updated successfully.'
            );
    }

    public function updateStatusWithTransaction(
        Request $request,
        Invoice $invoice
    ) {
        $data = $request->validate([

            'status' => [
                'required',
                'in:unpaid,paid'
            ],

            'transaction_id' => [
                'nullable',
                'string',
                'max:191'
            ],

            'invoice_date' => [
                'nullable',
                'date'
            ],

        ]);

        // paid validation
        if (
            $data['status'] === 'paid'
            && empty($data['transaction_id'])
        ) {

            return back()
                ->withErrors([

                    'transaction_id' =>
                    'Transaction ID is required when marking as PAID.'

                ])
                ->withInput();

        }

        $invoice->status = $data['status'];

        if (!empty($data['invoice_date'])) {

            $invoice->invoice_date = $data['invoice_date'];

        }

        $invoice->save();

        if ($data['status'] === 'paid') {

            $invoice->transactions()->create([

                'gateway'        => 'manual',

                'transaction_id' =>
                    $data['transaction_id'],

                'amount' => $invoice->total_amount,

                'paid_at' => Carbon::now(),

            ]);

            // PAYMENT ACTIVITY LOG
            ActivityLog::create([

                'user_id'     => auth()->id(),
                'action'      => 'payment',
                'module'      => 'invoice',
                'module_id'   => $invoice->id,
                'description' => 'Marked invoice #' . $invoice->invoice_number . ' as paid',

            ]);
        }

        return redirect()
            ->route('staff.invoices.edit', $invoice)
            ->with(
                'status',
                'Invoice updated.'
            );
    }
}