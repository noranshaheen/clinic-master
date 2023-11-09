<!doctype html>
<html dir="{{ App::getLocale() == 'en' ? 'ltr' : 'rtl'}}">

<head>
    <meta charset="utf-8">
    <title>Clinic Master</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
    <style>
        @media print {
            .btns {
                display: none;
            }

            .invoice {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper flex justify-between">
        <div class="invoice w-full lg:w-5/6 my-5 shadow-lg rounded-xl rtl:mr-2 ltr:ml-2">
            <div class="invoice-header flex justify-between">
                <div class="invoice-details self-center p-5">
                    <div class="mb-2">
                        <h2 class="text-3xl uppercase">@lang('Invoice')</h2>
                    </div>
                    <div>
                        <ul>
                            <!-- <li class="pb-2 text-gray-600">{{ __('Invoice Number') }}: {{ $data[0]->appointment->prescription->id}}</li> -->
                            <li class="pb-2 text-gray-600">{{ __('Doctor Name') }}: {{ $data[0]->doctor->name}}</li>
                            <li class="text-gray-600 pb-2">{{ __('Date Of Issue') }}: {{
                                \Carbon\Carbon::parse($data[0]->date)->toDateString() }}</li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-details self-center p-5">
                    <div class="mb-2">
                        <h2 class="text-3xl uppercase">@lang('Billed To')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">{{ __('Patient') }} : {{ $data[0]->patient->name }}</li>
                            <li class="pb-2 text-gray-600">{{ __('Phone Number') }} : {{ $data[0]->patient->phone }}</li>
                            <li class="text-gray-600 pb-2">{{ __('Gender') }} : {{ $data[0]->patient->gender == 'F'? __('Female'):__('Male') }}</li>
                            <li class="pb-2 text-gray-600">{{ __('Detection Type') }} : {{ __($data[0]->appointment->type)}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="items p-5">
                <table class="w-full">
                    <thead class="text-center bg-gray-300">
                        <tr>
                            <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __('Item') }}</th>
                            <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __('Unit Price') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center border border-[#eceeef]">
                        <tr>
                            <td class="p-2 border border-[#eceeef] font-bold">{{ __('Detection Fees') }}</td>
                            <td class="p-2 border border-[#eceeef] font-bold">
                                {{ $data[0]->appointment->amount }}
                            </td>
                        </tr>
                        <tr>
                            @php
                            $total = 0;
                            foreach ($data[0]->appointment->fees as $fee)
                            $total += $fee->price;
                            @endphp

                            <td class="p-2 border border-[#eceeef] font-bold">{{ __('Service Fees') }}</td>
                            <td class="p-2 border border-[#eceeef] font-bold">
                                {{ $total }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="invoice-total py-5 text-right">
                    <h4 class="capitalize py-2 text-gray-600 text-xl font-bold">{{ __('Invoice Total') }}:
                        {{sprintf("%0.2f", ($data[0]->appointment->amount + $total))}}
                        {{ __(' EGP')}}
                    </h4>
                    @php
                    $total_paid = 0;
                    foreach ($data as $payment)
                    $total_paid += $payment->paid_amount;
                    @endphp
                    <h4 class="capitalize py-2 text-gray-600 text-xl font-bold">{{ __('Paid') }}:
                        {{sprintf("%0.2f",($total_paid))}}
                        {{ __(' EGP')}}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</body>

</html>