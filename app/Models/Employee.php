<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 

class Employee extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    protected $guard_name = 'employee';  // <-- ये लाइन जरूरी है
    protected $guard = 'employee';

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function tasks()
    {
        return $this->hasMany(TaskManagement::class, 'assigned_to', 'id');
    }

    public function role() 
    {
        return $this->belongsTo(Role::class);
    }
}
