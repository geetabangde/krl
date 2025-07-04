<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    protected $table = 'role_has_permissions';

    // No timestamps in this pivot table
    public $timestamps = false;


    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
