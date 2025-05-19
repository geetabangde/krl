<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerMaster extends Model
{
    use HasFactory;
    protected $table = 'ledger_master';

    protected $fillable = [
        'ledger_name', 
        'group_id',
        'pan',
        'tan',
        'gst'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id'); 
    }

    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id'); 
    }

}
