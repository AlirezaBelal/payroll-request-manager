<div wire:poll.30s="loadNotifications">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="notificationsDropdown"
           data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell fs-5"></i>
            @if($unreadCount > 0)
                <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle"
                      style="font-size: 0.6rem;">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notificationsDropdown"
             style="min-width: 280px; max-width: 320px;">
            <div class="dropdown-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">اعلان‌ها</span>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead"
                            class="btn btn-link btn-sm p-0 text-decoration-none text-primary">
                        خواندن همه
                    </button>
                @endif
            </div>

            <div class="notifications-container" style="max-height: 350px; overflow-y: auto;">
                @forelse($notifications as $notification)
                    <div class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('expenses.my') }}" class="text-decoration-none">
                                @if(isset($notification->data['status']))
                                    @if($notification->data['status'] == 'pending')
                                        <span class="text-primary">
                                            <i class="bi bi-hourglass me-1"></i>
                                            ثبت درخواست هزینه
                                        </span>
                                    @elseif($notification->data['status'] == 'hr_approved')
                                        <span class="text-info">
                                            <i class="bi bi-check-circle me-1"></i>
                                            تایید منابع انسانی
                                        </span>
                                    @elseif($notification->data['status'] == 'finance_approved')
                                        <span class="text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            تایید مالی
                                        </span>
                                    @elseif($notification->data['status'] == 'rejected')
                                        <span class="text-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            رد درخواست
                                        </span>
                                    @endif
                                @else
                                    <span class="text-secondary">اعلان سیستم</span>
                                @endif
                            </a>

                            @unless($notification->read_at)
                                <button wire:click="markAsRead('{{ $notification->id }}')"
                                        class="btn btn-link btn-sm p-0 text-muted"
                                        title="علامت‌گذاری به عنوان خوانده شده">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            @endunless
                        </div>

                        @if(isset($notification->data['amount']))
                            <div class="small text-muted mt-1">
                                مبلغ: {{ number_format($notification->data['amount']) }} ریال
                            </div>
                        @endif

                        @if(isset($notification->data['comment']) && $notification->data['comment'])
                            <div class="small mt-1 p-1 bg-light rounded border-start border-4
                                {{ $notification->data['status'] == 'rejected' ? 'border-danger' : 'border-info' }}">
                                {{ \Illuminate\Support\Str::limit($notification->data['comment'], 50) }}
                            </div>
                        @endif

                        <div class="small text-muted mt-1 d-flex align-items-center">
                            <i class="bi bi-clock me-1" style="font-size: 0.7rem;"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>

                    @if(!$loop->last)
                        <div class="dropdown-divider m-0"></div>
                    @endif
                @empty
                    <div class="dropdown-item text-center py-3 text-muted">
                        <i class="bi bi-bell-slash me-1"></i>
                        اعلان جدیدی وجود ندارد
                    </div>
                @endforelse
            </div>

            @if(count($notifications) > 0)
                <div class="dropdown-divider m-0"></div>
                <a class="dropdown-item text-center py-2 text-primary" href="{{ route('notifications.index') }}">
                    مشاهده همه اعلان‌ها
                </a>
            @endif
        </div>
    </div>
</div>
