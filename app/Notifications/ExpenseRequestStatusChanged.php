<?php

namespace App\Notifications;

use App\Models\ExpenseRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseRequestStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $expenseRequest;
    protected $status;
    protected $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(ExpenseRequest $expenseRequest, string $status, ?string $comment = null)
    {
        $this->expenseRequest = $expenseRequest;
        $this->status = $status;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'pending' => 'درخواست هزینه شما ثبت شد و در انتظار تایید منابع انسانی می‌باشد.',
            'hr_approved' => 'درخواست هزینه شما توسط منابع انسانی تایید شد و در انتظار تایید واحد مالی می‌باشد.',
            'finance_approved' => 'درخواست هزینه شما توسط واحد مالی نیز تایید شد و در مرحله پرداخت قرار گرفت.',
            'rejected' => 'متاسفانه درخواست هزینه شما رد شد.',
        ];

        $mailMessage = (new MailMessage)
            ->subject('تغییر وضعیت درخواست هزینه')
            ->greeting('کاربر گرامی ' . $notifiable->name)
            ->line($statusMessages[$this->status] ?? 'وضعیت درخواست هزینه شما تغییر کرد.')
            ->line('مبلغ درخواست: ' . number_format($this->expenseRequest->amount) . ' ریال')
            ->line('تاریخ ثبت: ' . now()->format('Y/m/d H:i'));

        // اگر توضیحات وجود داشته باشد، به ایمیل اضافه می‌شود
        if ($this->comment) {
            $mailMessage->line('توضیحات: ' . $this->comment);
        }

        return $mailMessage
            ->action('مشاهده درخواست', route('expenses.my'))
            ->line('با تشکر از شما');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'expense_request_id' => $this->expenseRequest->id,
            'status' => $this->status,
            'comment' => $this->comment,
            'amount' => $this->expenseRequest->amount,
        ];
    }
}
