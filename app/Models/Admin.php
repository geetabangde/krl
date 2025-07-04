<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    protected $guard = 'admin'; 
        protected $guard_name = 'admin'; // IMPORTANT

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_name',
        'designation',
        'salary',
        'department',
        'date_of_joining',
        'phone_number',
        'emergency_contact_number',
        'address',
        'state',
        'pin_code',
        'aadhaar_number',
        'pan_number',
        'bank_account_number',
        'ifsc_code',
        'employee_photo',
        'status',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role() {
        return $this->belongsTo(Role::class);
    }

   public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function tasks()
    {
        return $this->hasMany(TaskManagement::class, 'assigned_to', 'id');
    }


}