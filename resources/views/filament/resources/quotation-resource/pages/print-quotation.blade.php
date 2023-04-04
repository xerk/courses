<x-filament::page>
    {{-- Create print Quotation page #{{ $record->id }} - {{ $record->name }} - {{ $record->company->name }} --}}
    {{-- Print Button --}}
    <div class="text-right">
        <x-filament::button class="mb-4 text-right" type="button" onclick="window.print()">Print</x-filament::button>
    </div>
    <x-filament::card>
        <div id="section-to-print">
            <div>Logo</div>
            @if ($this->record->type == 'invoice')
            <div class="text-center">
                <div class="font-semibold text-xl">TAX INVOICE</div>
                <div class="font-semibold text-xl">فاتورة ضريبية</div>
            </div>
            @else
            <div class="text-center">
                <div class="font-semibold text-xl">Quotation</div>
                <div class="font-semibold text-xl">عرض سعر</div>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-4 py-2">
                <div class="border border-gray-800 p-4 rounded-lg">
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">Bill To:</div>
                        <div class="col-span-8">{{ $this->record->bill_to }}</div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">Tel:</div>
                        <div class="col-span-8">{{ $this->record->tel }}</div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">TRN:</div>
                        <div class="col-span-8">{{ $this->record->trn }}</div>
                    </div>
                </div>
                <div class="border border-gray-100 p-4 rounded-lg">
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">Company Name:</div>
                        <div class="col-span-8">{{ $this->record->quotationTemplate->company_name }}</div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">Tel:</div>
                        <div class="col-span-8">{{ $this->record->quotationTemplate->company_phone }}</div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">P.O BOX:</div>
                        <div class="col-span-8">{{ $this->record->quotationTemplate->p_o_box }}</div>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 font-semibold">TRN:</div>
                        <div class="col-span-8">{{ $this->record->quotationTemplate->trn }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4 border border-gray-800 rounded">
                <div class="text-center  border-r border-gray-800">
                    <div class="py-2">
                        @if ($this->record->type == 'invoice')
                        <div>تاريخ الفتاورة الضريبية</div>
                        <div>Tax Invoice Date</div>
                        @else
                        <div>تاريخ الاصدار</div>
                        <div>Issue Date</div>
                        @endif
                    </div>
                    <div class="py-2 border-t border-gray-800">
                        {{ $this->record->tax_invoice_date }}
                    </div>
                </div>
                <div class="text-center  border-r border-gray-800">
                    <div class="py-2">
                        @if ($this->record->type == 'invoice')
                        <div>رقم الفاتورة الضريبية</div>
                        <div>Tax Invoice Number</div>
                        @else
                        <div>رقم عرض السعر</div>
                        <div>Quote Number</div>
                        @endif
                    </div>
                    <div class="py-2 border-t border-gray-800">
                        {{ $this->record->tax_invoice_no }}
                    </div>
                </div>
                <div class="text-center  border-r border-gray-800">
                    <div class="py-2">
                        <div>تاريخ التوريد</div>
                        <div>Supply Date</div>
                    </div>
                    <div class="py-2 border-t border-gray-800">
                        {{ $this->record->supply_date }}
                    </div>
                </div>
                <div class="text-center">
                    <div class="py-2">
                        <div>رقم أمر الشراء - العقد</div>
                        <div>LPO / Cont #</div>
                    </div>
                    <div class="py-2 border-t border-gray-800">
                        {{ $this->record->lpo_count }}
                    </div>
                </div>
            </div>


            <div class="py-2">
                <table class="table-auto w-full rounded-lg">
                    <thead class="">
                        <tr class="">
                            <th class="border border-gray-800 w-8">
                                <div>م</div>
                                <div>s</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>البيان</div>
                                <div>Description</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>الكملية</div>
                                <div>Quantity</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>السعر</div>
                                <div>Price</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>قيمة الاعمال</div>
                                <div>Net Amount</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>قيمة الضريبة</div>
                                <div>Vat Amount</div>
                                <div>(5%)</div>
                            </th>
                            <th class="border border-gray-800">
                                <div>المجموع - درهم</div>
                                <div>Total - AED</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->record->quotationItems as $item)
                        <tr class="text-center">
                            <td class="border border-gray-800 px-2 py-0.5">{{ $loop->iteration }}</td>
                            <td class="text-left border border-gray-800 px-2 py-0.5">{{ $item->course->title }}</td>
                            <td class="border border-gray-800 px-2 py-0.5">{{ $item->unit }}</td>
                            <td class="border border-gray-800 px-2 py-0.5">{{ $item->price }}</td>
                            <td class="border border-gray-800 px-2 py-0.5">{{ $item->net_count }}</td>
                            <td class="border border-gray-800 px-2 py-0.5">{{ $item->vat_amount }}</td>
                            <td class="border border-gray-800 px-2 py-0.5">{{ $item->total }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="border border-gray-800 font-semibold px-6 py-1" colspan="6">Total</td>
                            <td class="border border-gray-800 font-bold text-center">
                                @money($this->record->quotationItems->sum('total'))
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Bank Details --}}
                <div class="py-4">
                    <div class="font-semibold text-primary-500">Bank Details</div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-1 font-semibold">Account No:</div>
                        <div class="col-span-4">10180981</div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-1 font-semibold">IBAN:</div>
                        <div class="col-span-4">AE4405000000000010180981</div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-1 font-semibold">Bank Name:</div>
                        <div class="col-span-4">ABu Dhabi Islamic Bank</div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-1 font-semibold">Bank Account Name:</div>
                        <div class="col-span-4">Quattro Training & Consultation Center</div>
                    </div>
                </div>

                {{-- Signatures --}}
                <div class="flex space-x-4 py-4" style="justify-content: space-around">
                    <div class="text-center">
                        <div class="pb-4">
                            <div class="font-semibold text-base">Signature</div>
                            <div class="font-semibold text-base">ألتوقيع</div>
                        </div>
                        <div>------------------------</div>
                    </div>
                    <div class="text-center">
                        <div class="pb-4">
                            <div class="font-semibold text-base">Stamp</div>
                            <div class="font-semibold text-base">الختم</div>
                        </div>
                        <div>------------------------</div>
                    </div>
                </div>
                <x-filament-support::hr class="pb-4" />

                {{-- Footer --}}
                <div class="text-center">
                    <div class="text-gray-500 text-xs">UAE, Abu Dhabi – Al Reem Island – Addax Tower – 22 nd .
                        Floor – Office: 2203</div>
                    <div class="text-gray-500 text-xs">+971263263206 – www.quattrocenter.com – Email:
                        qtc@quattrocenter.com</div>
                </div>
            </div>
    </x-filament::card>
</x-filament::page>

@push('beforeCoreScripts')
<style>
    @page {
        size: A4;
        margin: 0;
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

    tr:nth-child(even) {
        background-color: #dddddd5e;
    }

    tr:nth-child(od) {
        class="bg-white";
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
