<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $unreadCount = 0; // تعداد نوتیفیکیشن‌های خوانده نشده
    public $notifications = []; // لیست نوتیفیکیشن‌ها

    protected $listeners = ['refreshNotifications' => 'refreshCount']; // گوش دادن به رویدادها

    public function mount(): void
    {
        $this->loadNotifications();
    }

    // بارگذاری نوتیفیکیشن‌ها از پایگاه داده
    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotifications->count();
            $this->notifications = auth()->user()->notifications()->latest()->take(5)->get();
        }
    }

    public function refreshCount(): void
    {
        $this->loadNotifications();
    }

    public function markAsRead($notificationId): void
    {
        auth()->user()->notifications->where('id', $notificationId)->first()?->markAsRead();
        $this->loadNotifications();
    }

    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notifications-dropdown', [
            'notifications' => $this->notifications
        ]);
    }
}
