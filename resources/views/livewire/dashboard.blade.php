<div>
    <h1 class="text-2xl font-semibold mb-6">
        داشبورد {{ $userRole == 'super_admin' ? 'مدیریت' : ($userRole == 'hr' ? 'منابع انسانی' : ($userRole == 'finance' ? 'مالی' : 'کارمند')) }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- کارت‌های آماری -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">کل درخواست‌ها</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $totalRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">در انتظار تایید</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $pendingRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">تایید شده</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $approvedRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-50 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mr-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">رد شده</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $rejectedRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($userRole == 'super_admin' || $userRole == 'finance')
            <!-- کارت مبلغ کل تایید شده - فقط برای مدیر و مالی -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mr-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">مجموع تایید شده (ریال)</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($totalAmount) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- جدول درخواست‌های اخیر -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold mb-4">
                {{ $userRole == 'employee' ? 'درخواست‌های اخیر شما' :
                   ($userRole == 'hr' ? 'درخواست‌های در انتظار تایید شما' :
                   ($userRole == 'finance' ? 'درخواست‌های نیازمند تایید مالی' : 'درخواست‌های اخیر')) }}
            </h2>

            @if(count($recentRequests) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            @if($userRole != 'employee')
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    کارمند
                                </th>
                            @endif
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                مبلغ (ریال)
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                توضیحات
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                تاریخ ثبت
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                وضعیت
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                عملیات
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentRequests as $request)
                            <tr>
                                @if($userRole != 'employee')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}</div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($request->amount) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="text-sm text-gray-900">{{ \Illuminate\Support\Str::limit($request->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="text-sm text-gray-900">{{ $request->created_at->format('Y/m/d H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($request->status == 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                در انتظار تایید منابع انسانی
                                            </span>
                                    @elseif($request->status == 'hr_approved')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                تایید منابع انسانی
                                            </span>
                                    @elseif($request->status == 'finance_approved')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                تایید مالی
                                            </span>
                                    @elseif($request->status == 'rejected')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                رد شده
                                            </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('expenses.my') }}" class="text-indigo-600 hover:text-indigo-900">مشاهده</a>

                                    @if($userRole == 'hr' && $request->status == 'pending')
                                        <a href="{{ route('hr.expenses.pending') }}"
                                           class="mr-2 text-green-600 hover:text-green-900">تایید</a>
                                    @endif

                                    @if($userRole == 'finance' && $request->status == 'hr_approved')
                                        <a href="{{ route('finance.expenses.pending') }}"
                                           class="mr-2 text-green-600 hover:text-green-900">تایید</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-blue-50 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="mr-3">
                            <p class="text-sm text-blue-700">
                                {{ $userRole == 'employee' ? 'شما هنوز درخواستی ثبت نکرده‌اید.' : 'درخواستی برای نمایش وجود ندارد.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($userRole == 'employee')
        <!-- بخش دسترسی سریع -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-lg font-semibold mb-4">دسترسی سریع</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('expenses.create') }}"
                       class="bg-indigo-50 hover:bg-indigo-100 p-6 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 mx-auto mb-2"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="text-indigo-700 font-medium">ثبت درخواست جدید</span>
                    </a>

                    <a href="{{ route('expenses.my') }}"
                       class="bg-blue-50 hover:bg-blue-100 p-6 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mx-auto mb-2" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="text-blue-700 font-medium">مشاهده درخواست‌ها</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="bg-green-50 hover:bg-green-100 p-6 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mx-auto mb-2"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-green-700 font-medium">پروفایل من</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
