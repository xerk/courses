@php
$record = $record ?? \App\Models\Invoice::find(request()->route()->record);
// dd($record->invoiceTemplate)
@endphp
<x-filament::page>
    <div class="text-right">
        <x-filament::button id="print" onclick="printDiv('section-to-print')" >
            Print
        </x-filament::button>
    </div>



    <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
        <div class="p-8" id="section-to-print">
            <div class="flex justify-between items-end">
                <div style="align-self:flex-start">
                    <div class="font-bold">{{$record->invoiceTemplate->title_en}}</div>
                    <div>Tel: <span class="font-semibold">{{$record->invoiceTemplate->phone}}</span></div>
                    <div>P.O. Box: <span class="font-semibold">6745</span></div>
                    <div>Address: <span class="font-semibold">{{$record->invoiceTemplate->address_en}}</span></div>
                    <div>E-Mail: <span class="font-semibold">qtc@quattrocenter.com</span></div>
                    <div>website: <span class="font-semibold">www.quattrocenter.com</span></div>
                </div>
                <div class="text-center">
                    <img class="mx-auto" width="64px"
                        src="https://png.pngtree.com/element_origin_min_pic/16/09/20/1457e0dd321de52.jpg" alt="logo"
                        class="py-12">
                    <h3 class="fond-black text-3xl py-4">سند قبض</h3>
                    <h class="font-black text-3xl py-4">RECEIPT VOUCHER</h>
                </div>
                <div class="" style="align-self:flex-start" dir="rtl">
                    <div class="font-bold">{{$record->invoiceTemplate->title_ar}}</div>
                    <div>هاتف: <span class="font-semibold">{{$record->invoiceTemplate->phone}}</span></div>
                    <div>ص.ب. <span class="font-semibold">{{$record->invoiceTemplate->commercial_no}}</span></div>
                    <div>العنوان: <span class="font-semibold">{{$record->invoiceTemplate->address_ar}}</span></div>
                    <div>البريد الإلكتروني: <span class="font-semibold">{{$record->invoiceTemplate->email}}</span></div>
                    <div>الموقع الإلكتروني: <span class="font-semibold">{{$record->invoiceTemplate->website}}</span>
                    </div>
                </div>
            </div>
            <div class="py-6 max-w-5xl mx-auto">
                <div class="text-start">Receipt#: <span class="font-semibold">{{$record->id}}</span></div>
                <div class="text-right py-2">
                    <table>
                        <thead class="border-2 border-gray-600">
                            <tr>
                                <th class="w-32 text-center border-2 border-gray-600">فلس: Fils</th>
                                <th class="w-32 text-center border-2 border-gray-600">درهم: Dhs.</th>
                            </tr>
                        </thead>
                        <tbody class="border-2 border-gray-600 h-10 text-center font-bold">
                            <tr>
                                <td class="border-2 border-gray-600">{{ number_format($record->fils, 2, '.') }}</td>
                                <td class="border-2 border-gray-600">{{ number_format($record->fils, 2, '.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div dir="rtl" class="py-12">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-2 bg-white dark:bg-gray-800 pl-4">التاريخ: <span
                                    class="font-semibold">{{$record->date}}</span></div>
                            <div class="py-2 bg-white dark:bg-gray-800 pr-3">Date: <span
                                    class="font-semibold">{{$record->date}}</span></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-2 bg-white dark:bg-gray-800 pl-4">أستلمنا من السيد / السادة <span
                                    class="font-semibold">{{$record->received_from}}</span></div>
                            <div class="py-2 bg-white dark:bg-gray-800 pr-3">Received from Mr./M/s: <span
                                    class="font-semibold">{{$record->received_from}}</span></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-2 bg-white dark:bg-gray-800 pl-4">مبلغ وقدره درهم: <span
                                    class="font-semibold">{{$record->amount}} -
                                    ({{$record->amount_ar}})</span></div>
                            <div class="py-2 bg-white dark:bg-gray-800 pr-3">The Amount of: <span
                                    class="font-semibold">{{$record->amount}} -
                                    ({{$record->amount_en}})</span></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="pt-2 bg-white dark:bg-gray-800 pl-4">شيك رقم / نقدًا: <span
                                    class="font-semibold">{{$record->cheque_no}}</span></div>
                            <div class="pt-2 bg-white dark:bg-gray-800 pr-3">Cash / Cheque No: <span
                                    class="font-semibold">{{$record->cheque_no}}</span></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="pb-2 bg-white dark:bg-gray-800 pl-4">استحقاق: <span
                                    class="font-semibold">{{$record->due_date}}</span></div>
                            <div class="pb-2 bg-white dark:bg-gray-800 pr-3">Due Date: <span
                                    class="font-semibold">{{$record->due_date}}</span></div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-1 bg-white dark:bg-gray-800 pl-4">مسحوب علي: <span
                                    class="font-semibold">{{$record->bank}}</span></div>
                            <div class="py-1 bg-white dark:bg-gray-800 pr-3">Bank: <span
                                    class="font-semibold">{{$record->bank}}</span></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-1 bg-white dark:bg-gray-800 pl-4">حساب رقم: <span
                                    class="font-semibold">{{$record->account_no}}</span></div>
                            <div class="py-1 bg-white dark:bg-gray-800 pr-3">A/c No: <span
                                    class="font-semibold">{{$record->account_no}}</span></div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="py-2 bg-white dark:bg-gray-800 pl-4">وذلك عن: <span
                                    class="font-semibold">{{$record->being}}</span></div>
                            <div class="py-2 bg-white dark:bg-gray-800 pr-3">Being: <span
                                    class="font-semibold">{{$record->being}}</span></div>
                        </div>
                    </div>


                    <div class="flex justify-between py-12">
                        <div class="text-center">
                            <div class="py-2 font-semibold">{{$record->invoiceTemplate->received_by}}</div>
                            <div class="py-2">المستلم Reveived by</div>
                        </div>
                        <div class="text-center">
                            <div class="py-2 font-semibold">{{$record->invoiceTemplate->accountant_name}}</div>
                            <div class="py-2">المحاسب Accountant</div>
                        </div>
                        <div class="text-center">
                            <div class="py-2 font-semibold">{{$record->invoiceTemplate->received_by}}</div>
                            <div class="py-2">المدير Manager</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-filament::page>
@push('beforeCoreScripts')
<style>
    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        /* ... the rest of the rules ... */
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #section-to-print,
        #section-to-print * {
            visibility: visible;
        }

        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

@endpush

@push('scripts')
<script>
    function printDiv() {
        window.print();
    }
</script>

@endpush
