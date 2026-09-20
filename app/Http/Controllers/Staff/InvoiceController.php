<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceTransaction;
use App\Models\ActivityLog;
use App\Models\Company;
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

        $company = $user->company ?? Company::where('is_default', true)->first() ?? Company::first();

        if (!$company) {

            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'status',
                    'No company found. Please add Green Studio company in admin panel.'
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
        $company = auth()->user()->company ?? Company::where('is_default', true)->first() ?? Company::first();

        if (!$company) {

            abort(
                403,
                'No company assigned or configured.'
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
            'created_by'     => auth()->id(),
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
            'user_name'   => auth()->user()->name ?? 'User',
            'user_email'  => auth()->user()->email ?? '',
            'role'        => auth()->user()->role ?? '',
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

        $customers = Customer::orderBy('name')->get();

        return view(
            'staff.invoices.edit',
            compact('invoice', 'customers')
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

        // Keep transaction amount in sync with invoice total
        if ($invoice->transactions()->exists()) {
            $invoice->transactions()->update([
                'amount' => $grandTotal,
            ]);
        }

        // ACTIVITY LOG
        ActivityLog::create([

            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name ?? 'User',
            'user_email'  => auth()->user()->email ?? '',
            'role'        => auth()->user()->role ?? '',
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
            'payment_method' => [
                'nullable',
                'string',
                'max:100'
            ],
            'transaction_id' => [
                'nullable',
                'string',
                'max:191',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status === 'paid' && (empty($value) || strlen(trim($value)) < 3)) {
                        $fail('Transaction ID is strictly mandatory when marking an invoice as PAID.');
                    }
                },
            ],
            'invoice_date' => [
                'nullable',
                'date'
            ],
        ]);

        $invoice->status = $data['status'];

        if (!empty($data['invoice_date'])) {
            $invoice->invoice_date = $data['invoice_date'];
        }

        $invoice->save();

        if ($data['status'] === 'paid') {
            $method = !empty($data['payment_method']) ? $data['payment_method'] : 'UPI / Digital Payment';

            // Rule: Transaction date strictly matches invoice_date with standard daytime office time (14:30)
            $transactionDate = Carbon::parse($invoice->invoice_date)->setTime(14, 30, 0);

            // Ensure amount is never zero if invoice has items or total
            $txAmount = ($invoice->total_amount > 0) ? $invoice->total_amount : (float) $invoice->items()->sum('line_total');

            $existingTx = $invoice->transactions()->first();
            if ($existingTx) {
                $existingTx->update([
                    'gateway'        => $method,
                    'transaction_id' => $data['transaction_id'],
                    'amount'         => $txAmount,
                    'paid_at'        => $transactionDate,
                ]);
            } else {
                $invoice->transactions()->create([
                    'gateway'        => $method,
                    'transaction_id' => $data['transaction_id'],
                    'amount'         => $txAmount,
                    'paid_at'        => $transactionDate,
                ]);
            }

            // PAYMENT ACTIVITY LOG
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'user_name'   => auth()->user()->name ?? 'User',
                'user_email'  => auth()->user()->email ?? '',
                'role'        => auth()->user()->role ?? '',
                'action'      => 'payment',
                'module'      => 'invoice',
                'module_id'   => $invoice->id,
                'description' => 'Marked invoice #' . $invoice->invoice_number . ' as paid (Date: ' . $transactionDate->format('d-m-Y') . ')',
            ]);
        } else {
            // When marked unpaid, clear any active transactions
            $invoice->transactions()->delete();
        }

        return redirect()
            ->route('staff.invoices.edit', $invoice)
            ->with(
                'status',
                'Invoice updated.'
            );
    }

    public function updateBasic(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'invoice_number' => ['required', 'string', 'max:100', "unique:invoices,invoice_number,{$invoice->id}"],
            'customer_id'    => ['required', 'exists:customers,id'],
            'invoice_date'   => ['required', 'date'],
        ]);

        $customer = Customer::findOrFail($data['customer_id']);
        $company = $invoice->company ?? auth()->user()->company ?? Company::where('is_default', true)->first();

        $saleType = null;
        if ($company && $company->state && $customer->state) {
            $saleType = ($company->state === $customer->state) ? 'LOCAL' : 'CENTRAL';
        }

        $invoice->update([
            'invoice_number' => $data['invoice_number'],
            'customer_id'    => $customer->id,
            'invoice_date'   => $data['invoice_date'],
            'sale_type'      => $saleType,
        ]);

        // Re-calculate tax breakdown if sale type changed
        $taxableTotal = 0;
        $cgstTotal = 0;
        $sgstTotal = 0;
        $igstTotal = 0;
        $grandTotal = 0;

        foreach ($invoice->items as $item) {
            $lineTaxable = $item->rate;
            $taxRate = $item->gst_percent;
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

            $item->update([
                'taxable'     => $lineTaxable,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'line_total'  => $lineTotal,
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

        // Sync existing transaction date with invoice date
        if ($invoice->transactions()->exists()) {
            $txDate = Carbon::parse($invoice->invoice_date)->setTime(14, 30, 0);
            $invoice->transactions()->update([
                'paid_at' => $txDate,
                'amount'  => $invoice->total_amount,
            ]);
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name ?? 'User',
            'user_email'  => auth()->user()->email ?? '',
            'role'        => auth()->user()->role ?? '',
            'action'      => 'update',
            'module'      => 'invoice',
            'module_id'   => $invoice->id,
            'description' => 'Updated invoice details #' . $invoice->invoice_number,
        ]);

        return redirect()
            ->route('staff.invoices.edit', $invoice)
            ->with('status', 'Invoice basic details updated successfully.');
    }

    /**
     * Send invoice details directly to customer via configured email.
     */
    public function sendEmail(Invoice $invoice)
    {
        $invoice->load(['customer', 'items', 'company', 'transaction']);
        $customer = $invoice->customer;

        if (!$customer || empty($customer->email)) {
            return back()->with('error', '❌ Customer has no email address. Please update the customer profile with a valid email.');
        }

        \App\Models\MailSetting::applyConfig();

        $fromName = config('mail.from.name', 'Green Studio');
        $fromEmail = config('mail.from.address', 'billing@greenstudio.com');
        $recipient = $customer->email;
        $customerName = $customer->name ?? 'Valued Customer';
        $invoiceNumber = $invoice->invoice_number;
        $totalFormatted = number_format($invoice->total_amount, 2);
        $invoiceDate = \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y');
        $statusText = strtoupper($invoice->status);

        try {
            \Illuminate\Support\Facades\Mail::html(
                '<div style="font-family: Arial, sans-serif; max-width: 620px; margin: 0 auto; padding: 28px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;">'
                . '<div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 2px solid #16a34a; padding-bottom: 16px; margin-bottom: 24px;">'
                . '<div><h2 style="color: #16a34a; margin: 0; font-size: 24px; font-weight: 800;">🌿 Green Studio</h2>'
                . '<p style="margin: 4px 0 0; color: #64748b; font-size: 12px;">GSTIN: 10DYFPA2189J1ZO • Khagaria, Bihar</p></div>'
                . '<div style="text-align: right;"><span style="background: ' . ($invoice->status === 'paid' ? '#dcfce7' : '#fee2e2') . '; color: ' . ($invoice->status === 'paid' ? '#15803d' : '#b91c1c') . '; font-weight: 800; padding: 6px 14px; border-radius: 999px; font-size: 12px;">' . $statusText . '</span></div>'
                . '</div>'
                . '<p style="color: #1e293b; font-size: 15px;">Dear <strong>' . htmlspecialchars($customerName) . '</strong>,</p>'
                . '<p style="color: #475569; font-size: 14px; line-height: 1.6;">Thank you for your business. Please find below the summary of your GST Tax Invoice:</p>'
                . '<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin: 20px 0;">'
                . '<div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px;"><span style="color: #64748b;">Invoice Number:</span><strong style="color: #0f172a;">#' . htmlspecialchars($invoiceNumber) . '</strong></div>'
                . '<div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px;"><span style="color: #64748b;">Invoice Date:</span><span style="color: #0f172a;">' . $invoiceDate . '</span></div>'
                . '<div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px;"><span style="color: #64748b;">Total Amount:</span><strong style="color: #16a34a; font-size: 16px;">₹' . $totalFormatted . '</strong></div>'
                . '<div style="display: flex; justify-content: space-between; font-size: 13.5px;"><span style="color: #64748b;">Payment Status:</span><span style="font-weight: 700; color: ' . ($invoice->status === 'paid' ? '#16a34a' : '#dc2626') . ';">' . $statusText . '</span></div>'
                . '</div>'
                . '<p style="color: #64748b; font-size: 13px; line-height: 1.6;">This is a computer-generated invoice. For any queries, please contact Green Studio Support.</p>'
                . '<hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">'
                . '<p style="font-size: 11.5px; color: #94a3b8; margin: 0; text-align: center;">Green Studio • Koshi College Road, Chitragupt Nagar, Khagaria - 851205</p>'
                . '</div>',
                function ($message) use ($recipient, $fromName, $fromEmail, $invoiceNumber) {
                    $message->to($recipient)
                        ->subject("Invoice #{$invoiceNumber} - Green Studio GST Invoicing")
                        ->from($fromEmail, $fromName);
                }
            );

            ActivityLog::create([
                'user_id'     => auth()->id(),
                'user_name'   => auth()->user()->name ?? 'User',
                'user_email'  => auth()->user()->email ?? '',
                'role'        => auth()->user()->role ?? '',
                'action'      => 'email_sent',
                'module'      => 'invoice',
                'module_id'   => $invoice->id,
                'description' => "Emailed Invoice #{$invoiceNumber} to customer {$customerName} ({$recipient})",
            ]);

            return back()->with('status', "✅ Invoice #{$invoiceNumber} sent successfully to {$customerName} ({$recipient})!");
        } catch (\Throwable $e) {
            return back()->with('error', "❌ Failed to send email: " . $e->getMessage());
        }
    }
}