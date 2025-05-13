<div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" id="notificationsDropdown"
       data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-danger">{{ $unreadCount }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 280px; max-width: 320px;">
        <div class="dropdown-header d-flex justify-content-between align-items-center">
            <span>اعلان‌ها</span>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="btn btn-link btn-sm p-0 text-decoration-none">
                    خواندن همه
                </button>
            @endif
        </div>

        @forelse($notifications as $notification)
            <div class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('expenses.my') }}" class="text-decoration-none">
                        @if($notification->data['status'] == 'pending')
                            <span class="text-primary">ثبت درخواست هزینه</span>
                        @elseif($notification->data['status'] == 'hr_approved')
                            <span class="text-info">تایید منابع انسانی</span>
                        @elseif($notification->data['status'] == 'finance_approved')
                            <span class="text-success">تایید مالی</span>
                        @elseif($notification->data['status'] == 'rejected')
                            <span class="text-danger">رد درخواست</span>
                        @endif
                    </a>

                    @unless($notification->read_at)
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="btn btn-link btn-sm p-0">
                            <i class="bi bi-check-circle text-muted"></i>
                        </button>
                    @endunless
                </div>

                <div class="small text-muted">
                    مبلغ: {{ number_format($notification->data['amount']) }} ریال
                </div>

                @if(isset($notification->data['comment']) && $notification->data['comment'])
                    <div class="small">
                        {{ \Illuminate\Support\Str::limit($notification->data['comment'], 50) }}
                    </div>
                @endif

                <div class="small text-muted mt-1">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>

            @if(!$loop->last)
                <div class="dropdown-divider"></div>
            @endif
        @empty
            <div class="dropdown-item text-center">
                اعلان جدیدی وجود ندارد
            </div>
        @endforelse

        @if(count($notifications) > 0)
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
                مشاهده همه اعلان‌ها
            </a>
        @endif
    </div>
</div>
