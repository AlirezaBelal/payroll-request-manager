<div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">درخواست‌های من</h5>
            <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-light">
                <i class="bi bi-plus-lg"></i> درخواست جدید
            </a>
        </div>
        <div class="card-body">
            @if(count($requests) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>مبلغ (ریال)</th>
                            <th>توضیحات</th>
                            <th>تاریخ ثبت</th>
                            <th>وضعیت</th>
                            <th>فاکتور</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $index => $request)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ number_format($request->amount) }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($request->description, 50) }}</td>
                                <td>{{ $request->created_at->format('Y/m/d H:i') }}</td>
                                <td>
                                    @if($request->status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> در انتظار تایید منابع انسانی
                                            </span>
                                    @elseif($request->status == 'hr_approved')
                                        <span class="badge bg-info">
                                                <i class="bi bi-check-circle"></i> تایید منابع انسانی
                                            </span>
                                    @elseif($request->status == 'finance_approved')
                                        <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill"></i> تایید شده
                                            </span>
                                    @elseif($request->status == 'rejected')
                                        <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> رد شده
                                            </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $request->invoice_file) }}" target="_blank"
                                       class="btn btn-sm btn-secondary">
                                        <i class="bi bi-file-earmark-image"></i> مشاهده
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i> هیچ درخواستی ثبت نشده است.
                </div>
            @endif
        </div>
    </div>
</div>
