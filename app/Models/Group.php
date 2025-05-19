<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'sub_group',
        'parent_id',
    ];
    public function parent()
   {
    return $this->belongsTo(Group::class, 'parent_id');
   }

}
