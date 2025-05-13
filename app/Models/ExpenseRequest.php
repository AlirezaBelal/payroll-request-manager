<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'invoice_file',
        'status',
        'hr_comment',
        'finance_comment',
        'hr_approved_at',
        'finance_approved_at',
    ];

    protected $casts = [
        'hr_approved_at' => 'datetime',
        'finance_approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isHrApproved(): bool
    {
        return $this->status === 'hr_approved';
    }

    public function isFinanceApproved(): bool
    {
        return $this->status === 'finance_approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
