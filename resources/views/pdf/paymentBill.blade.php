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
                            <li class="pb-2 text-gray-600">{{ __('Invoice Number') }}: {{ $data->id}}</li>
                            <li class="pb-2 text-gray-600">{{ __('Doctor Name') }}: {{ $data->doctor->name}}</li>
                            <li class="text-gray-600 pb-2">{{ __('Date Of Issue') }}: {{
                                \Carbon\Carbon::parse($data->date)->toDateString() }}</li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-details self-center p-5">
                    <div class="mb-2">
                        <h2 class="text-3xl uppercase">@lang('Billed To')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">{{ __('Patient') }} : {{ $data->patient->name }}</li>
                            <li class="pb-2 text-gray-600">{{ __('Phone Number') }} : {{ $data->patient->phone }}</li>
                            <li class="text-gray-600 pb-2">{{ __('Gender') }} : {{ $data->patient->gender == 'F'? __('Female'):__('Male') }}</li>
                            <li class="pb-2 text-gray-600">{{ __('Detection Type') }} : {{ __($data->appointment->type)}}</li>
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
                                {{ $data->detection_fees }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 border border-[#eceeef] font-bold">{{ __('Service Fees') }}</td>
                            <td class="p-2 border border-[#eceeef] font-bold">
                                {{ $data->total_service_fees }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="invoice-total py-5 text-right">
                    <h4 class="capitalize py-2 text-gray-600 text-xl font-bold">{{ __('Invoice Total') }}:
                        {{sprintf("%0.2f", ($data->detection_fees + $data->total_service_fees))}}
                        {{ __(' EGP')}}
                    </h4>
                    <h4 class="capitalize py-2 text-gray-600 text-xl font-bold">{{ __('Paid') }}:
                        {{sprintf("%0.2f",($data->detection_fees + $data->paid_service_fees))}}
                        {{ __(' EGP')}}
                    </h4>
                </div>
            </div>
        </div>
        <div class="btns my-5 w-2/12 text-center">
            <a href="{{ route('pdf.payment.download' , ['id' => $data->id]) }}">
                <button class="bg-black text-white py-2 px-5 rounded ml-2">
                    <i class="fa fa-download"></i> {{ __('Save') }}
                </button>
            </a>
            <button class="bg-black text-white py-2 px-5 rounded ml-2" id="print">
                <i class="fa fa-print pointer-events-none"></i> {{ __('Print') }}</button>

            @if(App::getLocale() == 'en')
            <a href="{{ route('language' , 'ar') }}">
                <button class="text-white bg-[#4099de] px-5 py-2 rounded mt-2">
                    <i class="fa fa-flag"></i> AR
                </button>
            </a>
            @else
            <a href="{{ route('language' , 'en') }}">
                <button class="text-white bg-[#4099de] px-5 py-2 rounded mt-2">
                    <i class="fa fa-flag"></i> EN
                </button>
            </a>
            @endif
        </div>
    </div>
</body>
<script>
    document.querySelector('#print').addEventListener('click', (e) => print());
</script>

</html>