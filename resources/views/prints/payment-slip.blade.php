@php
    $lang = request('lang', 'ar');
@endphp
<!doctype html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : '' }}">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <style>
        body {
            text-align: right;
            -webkit-print-color-adjust: exact !important;
            font-family: 'Cairo', sans-serif;
        }

        @media print {
            .order-block {
                page-break-after: always;
            }
        }

        @page {
            margin-top: 5mm;
        }

        body {
            background-color: #ffffff;
            -webkit-print-color-adjust: exact;
        }

        .padding {
            padding: 2rem !important
        }


        th {
            background-color: #ddd;
        }

        h3 {
            font-size: 20px
        }

        h4 {
            font-size: 18px;
            line-height: 22px;
        }

        h5 {
            font-size: 15px;
            line-height: 26px;
            color: #3d405c;
            margin: 0px 0px 15px 0px;
            /* font-family: 'Circular Std Medium' */
        }

        .text-dark {
            color: #3d405c !important
        }

        .text-sm {
            font-size: 14px;
        }


        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
            }

            th {
                background-color: #f77940;
            }
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body class="m-1 mt-3">
    @foreach ($orders as $item)
        @php
            $total = $item->isBox() ? $item->orderGroup->total : $item->totalBeforeDiscount();
            $discount = $item->isBox() ? $item->orderGroup->orders->sum('discount_amount') : $item->discount_amount;
            $net = $item->isBox() ? $item->orderGroup->orders->sum('amount') : $item->amount;
            $textOrder = __('الطلب');
            $textOrder2 = __('رقم الطلب');
        @endphp

        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding order-block border border-6 my-3">

            <div class="col-12 d-flex justify-content-between align-items-start mt-2">
                <div class="col-6">
                    <h2 class="font-weight-bold text-center mb-4">فاتورة ضريبية</h2>
                    <div class="row text-center pt-2">
                        <div class="col-6">
                            <div class="text-muted">الرقم الفتورة</div>
                            <div class="font-weight-bold pt-1">{{ $item->invoice_number }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">التاريخ</div>
                            <div class="font-weight-bold pt-1" dir="ltr">{{ $item->created_at->format('Y / m / d - H:i:s') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 d-flex justify-content-end">
                    <div class="text-center">
                        <img
                        style="margin: -24px"
                        src="https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl={{
                            zatca()
                            ->sellerName('Zatca')
                            ->vatRegistrationNumber("123456789012345")
                            ->timestamp($item->created_at ?? now())
                            ->totalWithVat($total)
                            ->vatTotal('15.00')
                            ->toBase64()
                        }}" width="176px" />
                        <div class="position-relative font-weight-bold">{{ $textOrder2 }} {{ $item->zoho_inv_num ?? $item->id }}</div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="py-2">
                <h4 class="font-weight-bold mb-3">معلومات البائع</h4>
                <div class="row">
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">الاسم التجاري</div>
                        <div class="font-weight-bold">{{ setting('الاسم التجاري', '---') }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">العنوان</div>
                        <div class="font-weight-bold">{{ setting('العنوان', '---') }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">رقم تسجيل ضريبة القيمة المضافة</div>

                        <div class="font-weight-bold">{{ setting('الرقم الضريبي', '---') }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">رقم السجل التجاري</div>
                        <div class="font-weight-bold">{{ setting('الرقم التجاري', '---') }}</div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="py-2">
                <h4 class="font-weight-bold mt-4 mb-3">معلومات العميل</h4>
                <div class="row">
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">الاسم التجاري</div>
                        <div class="font-weight-bold">{{ optional($item->user)->company_name }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">العنوان</div>
                        <div class="font-weight-bold">{{ optional($item->user)->address }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">رقم السجل التجاري</div>

                        <div class="font-weight-bold">{{ optional($item->user)->commercial_number }}</div>
                    </div>
                    <div class="col-3 border-right">
                        <div class="text-muted mb-1">رقم تسجيل ضريبة القيمة المضافة</div>
                        <div class="font-weight-bold">{{ optional($item->user)->vat_number }}</div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="py-2">
                <h4 class="font-weight-bold mt-4 mb-3">معلومات الطلب</h4>
                <div class="row">
                    <div class="col-3 border-right">
                        <div class="text-muted mb-2">وقت التسليم</div>
                        <div class="font-weight-bold">{!! $item->deliveryDate() !!}</div>
                    </div>
                    <div class="col-3 border-right">
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">المدفوع:</span>
                            <span class="font-weight-bold">{{ $item->isPaid() ? $net : 0 }}</span>
                        </h5>
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">المدفوع:</span>
                            <span class="font-weight-bold">{{ $item->isPaid() ? 0 : $net }}</span>
                        </h5>
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">طريقة الدفع:</span>
                            <span class="font-weight-bold">{{ __($item->local_payment_by) }}</span>
                        </h5>
                    </div>
                    <div class="col-3 border-right">
                        <h5 class="mb-0">
                            <span class="text-muted">عدد عناصر الطلب:</span>
                            <span class="font-weight-bold">{{ $item->item_count }}</span>
                        </h5>
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">نوع الاستلام:</span>
                            <span class="font-weight-bold">{{ __($item->local_receipt_type) }}</span>
                        </h5>
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">نوع التوصيل:</span>
                            <span class="font-weight-bold">{{ __($item->local_freight_type) }}</span>
                        </h5>
                        @if($item->note)
                        <h5 class="text-dark mb-0">
                            <span class="text-muted">الملاحظات:</span>
                            <span class="font-weight-bold">{{ $item->note }}</span>
                        </h5>
                        @endif
                    </div>
                    <div class="col-3 border-right">
                        @isset($item->map_location)
                            <div class="text-center">
                                <img width="96" src="data:image/png;base64,{{ DNS2D::getBarcodePNG('https://maps.google.com/?q=' . $item->map_location['lat'] . ',' . $item->map_location['lng'], 'QRCODE', 6, 6) }}"
                                alt="barcode" />
                                <h5 class="text-muted">{{ __('العنوان علي الخريطة') }}</h5>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped table-bordered border border-1">
                        <thead>
                            <tr class="text-muted">
                                <th class="center">#</th>
                                {{--                        <th>{{ __('القسم') }}</th> --}}
                                <th>{{ __('التصنيف') }}</th>
                                {{--                        <th>{{ __('رقم التاجر') }}</th> --}}
                                <th>{{ __('سعر الوحدة') }}</th>
                                <th class="center">{{ __('الكمية') }}</th>
                                <th>{{ __('السعر بدون ضريبة') }}</th>
                                <th> نسبة الضريبة </th>
                                <th> قيمة الضريبة </th>
                                <th>{{ __('الإجمالي') }}</th>
                                {{--                        <th>{{ __('موقع التخزين') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{--                    @forelse($item->items()->notCanceled()->get() as $orderItem) --}}
                            @php
                                $orderItems = $item
                                    ->items()
                                    ->withTrashed()
                                    ->where(function ($q) {
                                        $q->where('is_box', 1);
                                    })
                                    ->orWhere(function ($q) use ($item) {
                                        $q->where('order_id', $item->id)
                                            ->where('is_box', 0)
                                            ->whereNull('box_product_id')
                                            ->whereNull('deleted_at');
                                    })
                                    ->notCanceled()
                                    ->get();
                            @endphp
                            @forelse($orderItems as $orderItem)
                                <tr>
                                    <td class="center">{{ $loop->iteration }}</td>
                                    {{--                            <td class="strong">{{ $orderItem->category->section->getName($lang) }}</td> --}}
                                    <td>
                                        {{ $orderItem->product->unit->getName($lang) . ' ' . $orderItem->category->getName($lang) }}
                                        @if ($item->isBox())
                                            <br>
                                            @php
                                                $deliveryOnTable = \App\Models\Orders\Order::compressOrdersGroupForDelegate($item)->delivery_on_table;
                                                $date = $deliveryOnTable->where('date', $item->delivery_on)->first();
                                                $text = '';
                                                if ($date) {
                                                    $text = int2str($date['index']);
                                                }
                                            @endphp
                                            - {{ __('الصندوق') }} {{ $text }}
                                        @endif
                                    </td>
                                    {{--     <td>{{ $orderItem->merchant_id }}</td> --}}
                                    <td>{{ number_format($orderItem->price_with_rate,2)  }}</td>
                                    <td class="center">{{ $orderItem->quantity }}</td>
                                    <td>{{ $totaltem = $orderItem->price_with_rate * $orderItem->quantity }}</td>
                                    <td> {{ setting('نسبة الضريبة المضافة') }}% </td>
                                    <td>{{ $totalVatValue = $totaltem * (setting('نسبة الضريبة المضافة')/100)  }}</td>
                                    <td>{{ $totaltem + $totalVatValue }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center" style="color: red;">
                                        <h2>طلب ملغي</h2>
                                    </td>
                                </tr>
                            @endforelse
                            @if ($orderItems)
                                <tr>
                                    <td class="center">{{ count($orderItems) + 1 }}</td>
                                    <td class="center">{{ __('اجور التوصيل') }}</td>
                                    <td>{{ $item->isBox() ? 0 : $item->delivery_cost_by_amount }}</td>
                                    <td class="center">1</td>
                                    <td>{{ $item->isBox() ? 0 : $item->delivery_cost_by_amount }}</td>
                                    <td> {{ setting('نسبة الضريبة المضافة') }}% </td>
                                    <td>{{ $totalDelivery = $item->isBox() ? 0 : ( ($item->delivery_cost_by_amount) * (setting('نسبة الضريبة المضافة')/100) )  }}</td>
                                    <td>{{ ($item->isBox() ? 0 : $item->delivery_cost_by_amount) + $totalDelivery }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if ($item->items()->notCanceled()->count())
                    <div class="row">
                        <div class="col-lg-2 col-sm-4 d-flex">
                        </div>
                        <div class="col-lg-10 col-sm-8 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ __('المجموع الفرعي') }}</strong>
                                        </td>
                                        <td class="text-left pl-4">{{ $item->amount_before_delivery_cost + $item->delivery_cost_by_amount    }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ __('الخصم') }}</strong>
                                        </td>
                                        <td class="text-left pl-4">{{ $discount }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td>
                                            <strong class="text-dark">{{ __('اجور التوصيل') }}</strong>
                                        </td>
                                        <td>{{ $item->isBox() ? 0 : $item->delivery_cost_by_amount }}</td>
                                    </tr> --}}
                                    <tr>
                                        <td>
                                            <strong class="text-dark"> {{ __('ضريبة القيمة المضافة') }} (15%) </strong>
                                        </td>
                                        <td class="text-left pl-4">{{ $item->isBox() ? 0 : round($item->taxAmount(), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ __('المجموع مع الضريبة (15%)') }}</strong>
                                        </td>
                                        <td class="text-left pl-4">
                                            <strong class="text-dark">{{ $total }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    @endforeach

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        // window.print();
    </script>
</body>

</html>
