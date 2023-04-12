<!doctype html>
<html dir="{{ App::getLocale() == 'en' ? 'ltr' : 'rtl'}}">

<head>
    <meta charset="utf-8">
    <title>Accounting Master</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .btns {
                display: none;
            }

            .invoice {
                box-shadow: none;
            }

            .footer {
                position: relative;
                top: -20px;
                height: 10px;
            }

        }
    </style>
</head>

<body>
    <div class="wrapper flex justify-center">
        <div class="invoice w-full lg:w-5/6 my-5 shadow-lg rounded-xl rtl:mr-2 ltr:ml-2">
            <div class="invoice-header grid grid-cols-3">
                <div class="flex justify-start px-4">{{$book_data->accountingBook->name}}</div>
                <div class="flex justify-center py-4">
                    <div>إذن قيد يومية رقم {{$book_data->reference_code}}</div>
                </div>
                <div class="flex justify-end px-4">التاريخ : {{\Carbon\Carbon::parse($book_data->transaction_date)->toDateString()}}</div>
                <div class="flex justify-center col-span-3 py-4">{{$book_data->name}}</div>
            </div>
            <div class="items p-5">
                <table class="w-full">
                    <thead class="text-center bg-gray-200">
                        <tr>
                            <th class="p-3 border border-[#000000]">{{ __('Debit Amount') }}</th>
                            <th class="p-3 border border-[#000000]">{{ __('Credit Amount') }}</th>
                            <th class="p-3 border border-[#000000]">{{ __('Book Code') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center border border-[#eceeef]">
                        @foreach($book_data->entries ?? '' as $entry)
                        @if($entry['level'] == 0)
                        <tr>
                            <td class="p-2 border border-[#eceeef]">{{ sprintf("%0.2f", $entry['debit'])}}</td>
                            <td class="p-2 border border-[#eceeef]">{{ sprintf("%0.2f", $entry['credit'])}}</td>
                            <td class="p-2 border border-[#eceeef]">{{ sprintf("%s(%d)", $entry->account['name'], $entry->account['id']) }}</td>

                        </tr>
                        @else
                        <tr>
                            <td class="p-2 border border-[#eceeef]"></td>
                            <td class="p-2 border border-[#eceeef]"></td>
                            @if($entry['debit'] > 0 && $entry['level'] == 99)
                            <td class="p-2 border border-[#eceeef]">{{ __('From Acc.') . sprintf(" %s(%d)", $entry['name'], $entry['id']) }}</td>
                            @elseif($entry['credit'] > 0 && $entry['level'] == 99)
                            <td class="p-2 border border-[#eceeef]">{{ __('To Acc.') . sprintf(" %s(%d)", $entry['name'], $entry['id']) }}</td>
                            @else
                            <td class="p-2 border border-[#eceeef]">{{ sprintf("%s(%d)", $entry['name'], $entry['id']) }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                        <tr class="bg-gray-200">
                            <td class="p-2 border border-[#eceeef]">{{ $book_data->debit }}</td>
                            <td class="p-2 border border-[#eceeef]">{{ $book_data->credit }}</td>
                            <td class="p-2 border border-[#eceeef]">{{ __('Total') }}<br> {{ Numbers::TafqeetMoney(round($book_data->debit, 2),'EGP') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="footer p-4">
                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> {{__('Accountant') }}</h4>
                            </td>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> {{__('Reviewer') }}</h4>
                            </td>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> {{__('Accounting Department Head') }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> ----------------------------</h4>
                            </td>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> ----------------------------</h4>
                            </td>
                            <td style="width:50px;"></td>
                            <td style="width:33%;">
                                <h4 class="capitalize text-gray-600 text-xl font-bold"> ----------------------------</h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="btns my-5 w-full flex justify-center">
        <button class="bg-black text-white py-2 px-5 rounded ml-2">
            <a href="{{ route('pdf.invoice.download' , ['id' => $book_data->id]) }}">
                <i class="fa fa-download"></i> {{ __('Save') }}
            </a>
        </button>
        <button class="bg-black text-white py-2 px-5 rounded ml-2" id="print">
            <i class="fa fa-print pointer-events-none"></i> {{ __('Print') }}
        </button>

        @if(App::getLocale() == 'en')
        <button class="text-white bg-[#4099de] px-5 py-2 rounded ml-2">
            <a href="{{ route('language' , 'ar') }}">
                <i class="fa fa-flag"></i> AR
            </a>
        </button>
        @else
        <button class="text-white bg-[#4099de] px-5 py-2 rounded ml-2">
            <a href="{{ route('language' , 'en') }}">
                <i class="fa fa-flag"></i> EN
            </a>
        </button>
        @endif

    </div>
</body>
<script>
    document.querySelector('#print').addEventListener('click', (e) => print());
</script>

</html>