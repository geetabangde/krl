<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherPermission extends Model
{
    protected $fillable = [
        'voucher_type',
        'permission_type',
        'group_id',
        'group_name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
