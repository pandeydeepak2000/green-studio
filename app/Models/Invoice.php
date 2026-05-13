<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'company_id',
        'customer_id',
        'sale_type',
        'taxable_amount',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'invoice_date'   => 'date',

        'taxable_amount' => 'decimal:2',
        'cgst_amount'    => 'decimal:2',
        'sgst_amount'    => 'decimal:2',
        'igst_amount'    => 'decimal:2',
        'total_amount'   => 'decimal:2',
    ];
public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(InvoiceTransaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getTotalGstAttribute()
    {
        return
            $this->cgst_amount +
            $this->sgst_amount +
            $this->igst_amount;
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->status === 'unpaid';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }
}