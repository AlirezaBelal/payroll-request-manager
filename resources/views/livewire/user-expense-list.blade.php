<div>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">درخواست‌های من</h3>
        </div>
        <div class="card-body">
            @if(count($requests) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
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
                                        <span class="badge text-bg-{{ $request->status_color }}">
                                            {{ $request->status_label }}
                                        </span>
                                    @if($request->isRejected() && $request->hr_comment)
                                        <button class="btn btn-sm btn-link text-danger"
                                                data-bs-toggle="tooltip"
                                                title="{{ $request->hr_comment ?: $request->finance_comment }}">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $request->invoice_file) }}" target="_blank"
                                       class="btn btn-sm btn-secondary">
                                        <i class="bi bi-file-image"></i> مشاهده
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
                    هیچ درخواستی ثبت نشده است.
                </div>
            @endif
        </div>
    </div>
</div>
