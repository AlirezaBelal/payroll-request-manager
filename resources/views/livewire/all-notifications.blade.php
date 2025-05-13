<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('اعلان‌ها') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session()->has('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">لیست همه اعلان‌ها</h3>

                        <div class="flex space-x-2 space-x-reverse">
                            <button wire:click="markAllAsRead" type="button"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                علامت‌گذاری همه به عنوان خوانده شده
                            </button>

                            <button wire:click="deleteAll" type="button"
                                    onclick="confirm('آیا از حذف تمام اعلان‌ها اطمینان دارید؟') || event.stopImmediatePropagation()"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                حذف همه
                            </button>
                        </div>
                    </div>

                    @if(count($notifications) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        تاریخ
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        نوع
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        پیام
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
                                @foreach($notifications as $notification)
                                    <tr class="{{ $notification->read_at ? '' : 'bg-blue-50' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $notification->created_at->format('Y/m/d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($notification->data['status']))
                                                @if($notification->data['status'] == 'pending')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            ثبت درخواست
                                                        </span>
                                                @elseif($notification->data['status'] == 'hr_approved')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            تایید HR
                                                        </span>
                                                @elseif($notification->data['status'] == 'finance_approved')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            تایید مالی
                                                        </span>
                                                @elseif($notification->data['status'] == 'rejected')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            رد شده
                                                        </span>
                                                @endif
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        سیستمی
                                                    </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div>
                                                @if(isset($notification->data['status']))
                                                    @if($notification->data['status'] == 'pending')
                                                        درخواست هزینه جدید به
                                                        مبلغ {{ number_format($notification->data['amount']) }} ریال ثبت
                                                        شد.
                                                    @elseif($notification->data['status'] == 'hr_approved')
                                                        درخواست هزینه به
                                                        مبلغ {{ number_format($notification->data['amount']) }} ریال
                                                        توسط منابع انسانی تایید شد.
                                                    @elseif($notification->data['status'] == 'finance_approved')
                                                        درخواست هزینه به
                                                        مبلغ {{ number_format($notification->data['amount']) }} ریال
                                                        توسط واحد مالی تایید شد.
                                                    @elseif($notification->data['status'] == 'rejected')
                                                        درخواست هزینه به
                                                        مبلغ {{ number_format($notification->data['amount']) }} ریال رد
                                                        شد.
                                                    @endif
                                                @else
                                                    {{ $notification->data['message'] ?? 'پیام سیستم' }}
                                                @endif
                                            </div>

                                            @if(isset($notification->data['comment']) && $notification->data['comment'])
                                                <div
                                                    class="mt-2 text-xs p-2 bg-gray-50 rounded border-r-4 {{ $notification->data['status'] == 'rejected' ? 'border-red-500' : 'border-blue-500' }}">
                                                    {{ $notification->data['comment'] }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($notification->read_at)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        خوانده شده
                                                    </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        جدید
                                                    </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2 space-x-reverse">
                                                @unless($notification->read_at)
                                                    <button wire:click="markAsRead('{{ $notification->id }}')"
                                                            class="text-blue-600 hover:text-blue-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                @endunless

                                                <button wire:click="delete('{{ $notification->id }}')"
                                                        onclick="confirm('آیا از حذف این اعلان اطمینان دارید؟') || event.stopImmediatePropagation()"
                                                        class="text-red-600 hover:text-red-900">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="bg-blue-50 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="mr-3">
                                    <p class="text-sm text-blue-700">
                                        اعلانی وجود ندارد.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
