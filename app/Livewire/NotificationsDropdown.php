<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $unreadCount;

    protected $listeners = ['refreshNotifications' => 'refreshCount'];

    public function mount()
    {
        $this->refreshCount();
    }

    public function refreshCount()
    {
        $this->unreadCount = auth()->user()->unreadNotifications->count();
    }

    public function markAsRead($notificationId)
    {
        auth()->user()->notifications->where('id', $notificationId)->first()?->markAsRead();
        $this->refreshCount();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->refreshCount();
    }

    public function render()
    {
        return view('livewire.notifications-dropdown', [
            'notifications' => auth()->user()->notifications()->latest()->take(5)->get()
        ]);
    }
}
