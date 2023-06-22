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
                        <h2 class="text-3xl uppercase">@lang('Prescription')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">{{ __('Prescription Number') }}: {{ $data->id}}</li>
                            <li class="pb-2 text-gray-600">{{ __('Doctor Name') }}: {{ $data->doctor->name}}</li>
                            <li class="text-gray-600 pb-2">{{ __('Date Of Issue') }}: {{
                                \Carbon\Carbon::parse($data->dateTimeIssued)->toDateString() }}</li>
                            <li class="text-gray-600 pb-2">{{ __('Time Of Issue') }}: {{
                                \Carbon\Carbon::parse($data->dateTimeIssued)->toTimeString() }}</li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-details self-center p-5">
                    <div class="mb-2">
                        <h2 class="text-3xl uppercase">@lang('Patient')</h2>
                    </div>
                    <div>
                    <ul>
                        <li class="text-gray-600">
                        {{ __('Patient Name') }}:  {{ $data->patient->name }}
                        </li>
                        <li class="text-gray-600">
                        {{ __('Phone Number') }}:  {{ $data->patient->phone }}
                        </li>
                        <li class="text-gray-600 pb-2">
                            {{ __('Gender') }}: {{ $data->patient->gender == 'F'? __('Female'):__('Male') }}
                        </li>
                        <li class="text-gray-600 pb-2">
                            {{ __('Diagnosis') }}:
                            @foreach(json_decode($data->diagnosis) as $diagnose)
                            <li>
                                @php
                                echo $diagnose;
                                @endphp
                            </li>
                            @endforeach
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <!-- .........
            <div class="invoice-header grid grid-cols-3 gap-2">
                <div class="invoice-details self-center">
                    <div class="mb-2">
                        <h2 class="text-3xl uppercase">@lang('Prescription')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">{{ __('Prescription Number') }}: {{ $data->id}}</li>
                            <li class="pb-2 text-gray-600">{{ __('Doctor Name') }}: {{ $data->doctor->name}}</li>
                            <li class="text-gray-600 pb-2">{{ __('Date Of Issue') }}: {{
                                \Carbon\Carbon::parse($data->dateTimeIssued)->toDateString() }}</li>
                            <li class="text-gray-600 pb-2">{{ __('Time Of Issue') }}: {{
                                \Carbon\Carbon::parse($data->dateTimeIssued)->toTimeString() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="invoice-company-address flex justify-between p-5">
                <div class="billed-to">
                    <h4 class="mb-2 text-2xl">{{ __('Patient Details') }}:</h4>
                    <ul>
                        <li class="text-gray-600">
                            {{ $data->patient->name }}
                        </li>
                        <li class="text-gray-600">
                            {{ $data->patient->phone }}
                        </li>
                        <li class="text-gray-600 pb-2">
                            {{ __('Gender') }}: {{ $data->patient->gender == 'F'? 'Female':'Male' }}
                        </li>
                        <li class="text-gray-600 pb-2">
                            {{ __('Diagnosis') }}:
                            @foreach(json_decode($data->diagnosis) as $diagnose)
                            @php
                            echo "<br />"."- ".$diagnose;
                            @endphp
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div> -->
            <hr>
            <div class="items p-5">
                <table class="w-full">
                    <thead class="text-center bg-gray-300">
                        <tr>
                            <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __('Drug Name') }}</th>
                            <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __('Dose') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center border border-[#eceeef]">
                        @foreach ($data->prescriptionItems as $line)
                        <tr>
                            <td class="p-2 border border-[#eceeef]">{{ $line->drugs->name  }}</td>
                            <td class="p-2 border border-[#eceeef]">{{ $line->dose }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="invoice-total py-5 text-left">
                    <p class="capitalize py-2 text-gray-600">{{ __('Analysis') }}:
                        @foreach(json_decode($data->analysis) as $analysis)
                        @php
                        echo "<br />"."- ".$analysis;
                        @endphp
                        @endforeach
                    </p>
                    <p class="capitalize py-2 text-gray-600">{{ __('X-Rays') }}:
                        @foreach(json_decode($data->rays) as $ray)
                        @php
                        echo "<br />"."- ".$ray;
                        @endphp
                        @endforeach
                    </p>
                    <p class="capitalize py-2 text-gray-600">{{ __('Notes') }}:
                        {{ $data->notes}}
                    </p>
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