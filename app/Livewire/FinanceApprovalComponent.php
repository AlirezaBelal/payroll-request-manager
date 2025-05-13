<?php

namespace App\Livewire;

use App\Models\ExpenseRequest;
use App\Notifications\ExpenseRequestStatusChanged;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceApprovalComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $requestId;
    public $comment;
    public $isApproving = true;
    public $showCommentModal = false;

    protected $rules = [
        'comment' => 'nullable|string|max:500',
    ];

    protected $listeners = ['refreshList' => '$refresh'];

    public function approve($id)
    {
        $this->requestId = $id;
        $this->isApproving = true;
        $this->comment = '';
        $this->showCommentModal = true;
    }

    public function reject($id)
    {
        $this->requestId = $id;
        $this->isApproving = false;
        $this->comment = '';
        $this->showCommentModal = true;
    }

    public function confirmAction()
    {
        $this->validate();

        $request = ExpenseRequest::findOrFail($this->requestId);

        if ($this->isApproving) {
            $request->update([
                'status' => 'finance_approved',
                'finance_comment' => $this->comment,
                'finance_approved_at' => now(),
            ]);

            // ارسال نوتیفیکیشن به کاربر
            $request->user->notify(new ExpenseRequestStatusChanged($request, 'finance_approved', $this->comment));

            session()->flash('message', 'درخواست با موفقیت تایید شد.');
        } else {
            $request->update([
                'status' => 'rejected',
                'finance_comment' => $this->comment,
            ]);

            // ارسال نوتیفیکیشن به کاربر
            $request->user->notify(new ExpenseRequestStatusChanged($request, 'rejected', $this->comment));

            session()->flash('message', 'درخواست رد شد.');
        }

        $this->showCommentModal = false;
        $this->reset(['requestId', 'comment', 'isApproving']);
    }

    public function closeModal()
    {
        $this->showCommentModal = false;
        $this->reset(['requestId', 'comment', 'isApproving']);
    }

    public function render()
    {
        $hrApprovedRequests = ExpenseRequest::with('user')
            ->where('status', 'hr_approved')
            ->latest()
            ->paginate(10);

        return view('livewire.finance-approval-component', [
            'hrApprovedRequests' => $hrApprovedRequests
        ]);
    }
}
