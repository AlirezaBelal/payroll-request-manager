<div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">درخواست‌های در انتظار تایید مالی</h3>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if(count($hrApprovedRequests) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>کارمند</th>
                            <th>مبلغ (ریال)</th>
                            <th>شماره شبا</th>
                            <th>بانک</th>
                            <th>توضیحات</th>
                            <th>فاکتور</th>
                            <th>تاریخ تایید HR</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hrApprovedRequests as $index => $request)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $request->user->name }}</td>
                                <td>{{ number_format($request->amount) }}</td>
                                <td class="ltr">{{ $request->user->iban }}</td>
                                <td>{{ $request->user->bank_name }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($request->description, 50) }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $request->invoice_file) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-file-image"></i> مشاهده
                                    </a>
                                </td>
                                <td>{{ $request->hr_approved_at->format('Y/m/d H:i') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" wire:click="approve({{ $request->id }})" wire:loading.attr="disabled">
                                        <i class="bi bi-check-lg"></i> تایید
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="reject({{ $request->id }})" wire:loading.attr="disabled">
                                        <i class="bi bi-x-lg"></i> رد
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $hrApprovedRequests->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    هیچ درخواستی در انتظار تایید وجود ندارد.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for comments -->
    @if($showCommentModal)
        <div class="modal fade show" tabindex="-1" style="display: block; padding-right: 15px; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isApproving ? 'تایید درخواست' : 'رد درخواست' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="comment">توضیحات</label>
                            <textarea class="form-control" wire:model="comment" id="comment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">انصراف</button>
                        <button type="button" class="btn {{ $isApproving ? 'btn-success' : 'btn-danger' }}" wire:click="confirmAction">
                            {{ $isApproving ? 'تایید نهایی' : 'رد نهایی' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
