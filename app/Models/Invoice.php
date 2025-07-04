<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
     use HasFactory;
    protected $table = 'invoices';
    
    protected $fillable = [
        'freight_bill_id',
        'invoice_number',
        'invoice_date',
       
    ];

    public function freightBill()
{
    return $this->belongsTo(FreightBill::class);
}

}
