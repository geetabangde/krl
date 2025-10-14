<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_type',
        'voucher_no',
        'voucher_date',
        'from_ledger_id',
        'to_ledger_id',
        'amount',
        'description',
        'tally_narration',
        'narration',
        'assigned_to',
        'vouchers',
        'against_voucher',
        'transaction_id',
        'credit_day',
        'cash_credit',
        'tds_payable',
    ];

    
    protected $casts = [
        'vouchers' => 'array',
        
    ];
    
    // Fetch 'from' and 'to' ledgers based on group ID
    public function fromLedger()
    {
        return $this->belongsTo(LedgerMaster::class, 'from_ledger_id');
    }

    public function toLedger()
    {
        return $this->belongsTo(LedgerMaster::class, 'to_ledger_id');
    }

}
