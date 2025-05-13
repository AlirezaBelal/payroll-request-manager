<?php

namespace App\Livewire;

use App\Models\ExpenseRequest;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalRequests = 0;
    public $pendingRequests = 0;
    public $approvedRequests = 0;
    public $rejectedRequests = 0;
    public $totalAmount = 0;
    public $recentRequests = [];
    public $pendingAmount = 0;
    public $approvedAmount = 0;
    public $userRole;

    public function mount()
    {
        $this->userRole = auth()->user()->role;
        $this->loadDashboardData();
    }

    protected function loadDashboardData()
    {
        // آمار برای همه نقش‌ها
        if ($this->userRole === 'super_admin') {
            // آمار کلی برای مدیر
            $this->totalRequests = ExpenseRequest::count();
            $this->pendingRequests = ExpenseRequest::where('status', 'pending')->count();
            $this->approvedRequests = ExpenseRequest::where('status', 'finance_approved')->count();
            $this->rejectedRequests = ExpenseRequest::where('status', 'rejected')->count();
            $this->totalAmount = ExpenseRequest::where('status', 'finance_approved')->sum('amount');
            $this->pendingAmount = ExpenseRequest::whereIn('status', ['pending', 'hr_approved'])->sum('amount');
            $this->approvedAmount = ExpenseRequest::where('status', 'finance_approved')->sum('amount');
            $this->recentRequests = ExpenseRequest::with('user')->latest()->take(5)->get();
        } elseif ($this->userRole === 'hr') {
            // آمار برای منابع انسانی
            $this->totalRequests = ExpenseRequest::count();
            $this->pendingRequests = ExpenseRequest::where('status', 'pending')->count();
            $this->approvedRequests = ExpenseRequest::where('status', 'hr_approved')->orWhere('status', 'finance_approved')->count();
            $this->rejectedRequests = ExpenseRequest::where('status', 'rejected')->count();
            $this->recentRequests = ExpenseRequest::where('status', 'pending')->with('user')->latest()->take(5)->get();
        } elseif ($this->userRole === 'finance') {
            // آمار برای واحد مالی
            $this->totalRequests = ExpenseRequest::whereIn('status', ['hr_approved', 'finance_approved'])->count();
            $this->pendingRequests = ExpenseRequest::where('status', 'hr_approved')->count();
            $this->approvedRequests = ExpenseRequest::where('status', 'finance_approved')->count();
            $this->totalAmount = ExpenseRequest::where('status', 'finance_approved')->sum('amount');
            $this->recentRequests = ExpenseRequest::where('status', 'hr_approved')->with('user')->latest()->take(5)->get();
        } else {
            // آمار برای کارمند عادی
            $this->totalRequests = ExpenseRequest::where('user_id', auth()->id())->count();
            $this->pendingRequests = ExpenseRequest::where('user_id', auth()->id())->whereIn('status', ['pending', 'hr_approved'])->count();
            $this->approvedRequests = ExpenseRequest::where('user_id', auth()->id())->where('status', 'finance_approved')->count();
            $this->rejectedRequests = ExpenseRequest::where('user_id', auth()->id())->where('status', 'rejected')->count();
            $this->recentRequests = ExpenseRequest::where('user_id', auth()->id())->latest()->take(5)->get();
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
