<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'national_code',
        'role',
        'iban',
        'bank_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isHR(): bool
    {
        return $this->role === 'hr';
    }

    public function isFinance(): bool
    {
        return $this->role === 'finance';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function expenseRequests()
    {
        return $this->hasMany(ExpenseRequest::class);
    }
}
