<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">ثبت درخواست هزینه جدید</h3>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="saveRequest">
                <div class="form-group">
                    <label for="amount">مبلغ (ریال)</label>
                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                           wire:model="amount" id="amount">
                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              wire:model="description" id="description" rows="3"></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="iban">شماره شبا</label>
                    <div class="input-group">
                        <input type="text" class="form-control ltr-input @error('iban') is-invalid @enderror"
                               wire:model.debounce.500ms="iban" id="iban"
                               placeholder="IR000000000000000000000000">
                        @if($detectedBank != 'نامشخص')
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ $detectedBank }}
                                </span>
                            </div>
                        @endif
                    </div>
                    @error('iban') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="invoice">تصویر فاکتور</label>
                    <div class="custom-file">
                        <input type="file" class="form-control @error('invoice') is-invalid @enderror"
                               wire:model="invoice" id="invoice" accept="image/*">
                    </div>
                    <div wire:loading wire:target="invoice" class="mt-2">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">در حال آپلود...</span>
                        </div>
                        <span class="text-primary">در حال آپلود...</span>
                    </div>
                    @error('invoice') <span class="text-danger">{{ $message }}</span> @enderror
                    @if ($invoice)
                        <div class="mt-2">
                            <img src="{{ $invoice->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="saveRequest">ثبت درخواست</span>
                        <span wire:loading wire:target="saveRequest">
                            <div class="spinner-border spinner-border-sm text-light" role="status">
                                <span class="visually-hidden">در حال ثبت...</span>
                            </div>
                            در حال ثبت...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
