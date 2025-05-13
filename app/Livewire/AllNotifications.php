<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class AllNotifications extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    // متد علامت‌گذاری یک نوتیفیکیشن به عنوان خوانده شده
    public function markAsRead($id): void
    {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        session()->flash('success', 'اعلان به عنوان خوانده شده علامت‌گذاری شد.');
    }

    // متد علامت‌گذاری همه نوتیفیکیشن‌ها به عنوان خوانده شده
    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
        session()->flash('success', 'تمام اعلان‌ها به عنوان خوانده شده علامت‌گذاری شدند.');
    }

    // متد حذف یک نوتیفیکیشن
    public function delete($id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();
        session()->flash('success', 'اعلان با موفقیت حذف شد.');
    }

    // متد حذف همه نوتیفیکیشن‌ها
    public function deleteAll(): void
    {
        auth()->user()->notifications()->delete();
        session()->flash('success', 'تمام اعلان‌ها با موفقیت حذف شدند.');
    }

    public function render()
    {
        return view('livewire.all-notifications', [
            'notifications' => auth()->user()->notifications()->paginate(15)
        ])->layout('layouts.app');
    }
}
