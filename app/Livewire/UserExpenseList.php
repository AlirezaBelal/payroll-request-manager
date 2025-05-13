<?php

namespace App\Livewire;

use App\Models\ExpenseRequest;
use Livewire\Component;
use Livewire\WithPagination;

class UserExpenseList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $requests = ExpenseRequest::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.user-expense-list', [
            'requests' => $requests
        ]);
    }
}
