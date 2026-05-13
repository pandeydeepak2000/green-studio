<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with([
            'customer',
            'company',
            'creator'
        ]);

        $sort = $request->get('sort', 'newest');

        if ($sort === 'oldest') {

            $query->orderBy('invoice_date', 'asc');

        } else {

            $query->orderBy('invoice_date', 'desc');

        }

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
                )

                ->orWhereHas(
                    'company',
                    function ($qc) use ($search) {

                        $qc->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    }
                );

            });

        }

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

        $status = $request->get('status');

        if ($status) {

            $query->where('status', $status);

        }

        $invoices = $query->paginate(20);

        return view('admin.invoices.index', [

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
            'transactions',
            'creator'
        );

        return view(
            'admin.invoices.show',
            compact('invoice')
        );
    }
}