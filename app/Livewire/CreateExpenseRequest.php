<?php

namespace App\Livewire;

use App\Models\ExpenseRequest;
use App\Notifications\ExpenseRequestStatusChanged;
use App\Services\IbanService;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateExpenseRequest extends Component
{
    use WithFileUploads;

    public $amount;
    public $description;
    public $iban;
    public $invoice;
    public $detectedBank = 'نامشخص';

    protected $rules = [
        'amount' => 'required|numeric|min:1000',
        'description' => 'required|string|min:10',
        'iban' => 'required|string|regex:/^IR[0-9]{24}$/',
        'invoice' => 'required|image|max:2048',
    ];

    protected $messages = [
        'amount.required' => 'مبلغ هزینه الزامی است.',
        'amount.numeric' => 'مبلغ هزینه باید عدد باشد.',
        'amount.min' => 'حداقل مبلغ هزینه ۱,۰۰۰ ریال است.',
        'description.required' => 'توضیحات الزامی است.',
        'description.min' => 'توضیحات باید حداقل ۱۰ کاراکتر باشد.',
        'iban.required' => 'شماره شبا الزامی است.',
        'iban.regex' => 'فرمت شماره شبا صحیح نیست. شماره شبا باید با IR شروع شود و شامل ۲۴ رقم باشد.',
        'invoice.required' => 'تصویر فاکتور الزامی است.',
        'invoice.image' => 'فایل آپلود شده باید تصویر باشد.',
        'invoice.max' => 'حداکثر حجم فایل ۲ مگابایت است.',
    ];

    public function mount()
    {
        // پر کردن خودکار شماره شبا از پروفایل کاربر اگر قبلاً ثبت شده باشد
        $this->iban = auth()->user()->iban;

        if ($this->iban) {
            $this->detectBankFromIban();
        }
    }

    public function updatedIban()
    {
        $this->detectBankFromIban();
    }

    public function detectBankFromIban()
    {
        if (!empty($this->iban) && strlen($this->iban) >= 7) {
            $this->detectedBank = IbanService::detectBankName($this->iban);
        } else {
            $this->detectedBank = 'نامشخص';
        }
    }

    public function saveRequest()
    {
        $this->validate();

        // ذخیره شماره شبا در پروفایل کاربر
        auth()->user()->update([
            'iban' => $this->iban,
            'bank_name' => $this->detectedBank,
        ]);

        // آپلود فایل فاکتور
        $invoicePath = $this->invoice->store('invoices', 'public');

        // ایجاد درخواست هزینه
        $expenseRequest = ExpenseRequest::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'description' => $this->description,
            'invoice_file' => $invoicePath,
            'status' => 'pending',
        ]);

        // ارسال نوتیفیکیشن
        auth()->user()->notify(new ExpenseRequestStatusChanged($expenseRequest, 'pending'));

        $this->reset(['amount', 'description', 'invoice']);

        session()->flash('message', 'درخواست هزینه با موفقیت ثبت شد و در انتظار تایید منابع انسانی می‌باشد.');
    }

    public function render()
    {
        return view('livewire.create-expense-request');
    }
}
