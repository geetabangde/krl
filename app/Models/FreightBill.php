<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreightBill extends Model
{
    use HasFactory;
    protected $table = 'freight_bill';
    
    protected $fillable = [
        'order_id',
        'freight_bill_number',
        'lr_number',
        'notes',
    ];

    protected $casts = [
    'order_id' => 'array',
    'lr_number' => 'array',
    ];


    
    public function order()
    {
        
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    // In FreightBill.php
    public function invoice()
   {
    return $this->hasOne(Invoice::class, 'freight_bill_id');
   }

}



