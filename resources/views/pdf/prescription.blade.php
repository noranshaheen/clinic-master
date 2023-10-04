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
            <div class="invoice-header flex justify-between px-5">
                <div class="invoice-details self-center p-5">
                    <div class="mb-5">
                        <h2 class="text-3xl uppercase font-bold text-center">@lang('Doctor')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Doctor Name') }}</span>:
                                <span class="">{{ $data->doctor->name }}</span>
                            </li>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Title') }}</span>:
                                <span class="">{{ $data->doctor->title }}</span>
                            </li>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Specialty') }}</span>:
                                <span class="">{{ $data->doctor->specialties->name }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-details self-center p-5">
                    <div class="mb-5">
                        <h2 class="text-3xl uppercase font-bold text-center">@lang('Prescription')</h2>
                    </div>
                    <div>
                        <ul>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Prescription Number') }}</span> :
                                <span>{{ $data->id}}</span>
                            </li>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Detection Type') }}</span> :
                                <span>{{ __($data->appointment->type)}}</span>
                            </li>
                            <li class="pb-2 text-gray-600">
                                <span class="font-semibold">{{ __('Date Of Issue') }}</span> :
                                <span>
                                    {{\Carbon\Carbon::parse($data->dateTimeIssued)->toDateString() }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="items p-5">
                <div class="p-5">
                    <p class="text-gray-600 pb-2 font-semibold underline decoration-2 inline">
                        {{ __('Patient') }}
                    </p> :
                    <span class="text-gray-600 p-2">{{ $data->patient->name }}</span> -
                    <span class="text-gray-600 p-2">{{ $data->patient->phone }}</span> -
                    <span class="text-gray-600 p-2">{{ $data->patient->gender == 'F'? __('Female'):__('Male') }}</span>
                </div>
                <div class="mb-5 p-5">
                    <p class="text-gray-600 pb-2 font-semibold underline decoration-2 inline">
                        {{ __('Diagnosis') }}
                    </p> :
                    @php
                    $diagnosis = json_decode($data->diagnosis);
                    $x=count($diagnosis);
                    @endphp
                    @for($i=0 ; $i<$x ; $i++) <span class="text-gray-600 p-2">
                        @if($i == ($x-1))
                        @php
                        echo $diagnosis[$i]." . ";
                        @endphp
                        @else
                        @php
                        echo $diagnosis[$i].",";
                        @endphp
                        @endif
                        </span>
                        @endfor
                </div>
                <table class="w-full p-5">
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
                <div class="invoice-total p-5">
                    <div class="mb-2">
                        <p class="text-gray-600 pb-2 font-semibold underline decoration-2 inline">{{ __('Analysis') }} :</p>
                        <ul class="list-disc list-inside px-4">
                            @foreach(json_decode($data->analysis) as $analysis)
                            <li class="text-gray-600">
                                @php
                                echo $analysis;
                                @endphp
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-2">
                        <p class="text-gray-600 pb-2 font-semibold underline decoration-2 inline">{{ __('X-Rays') }} :</p>
                        <ul class="list-disc list-inside px-4">
                            @foreach(json_decode($data->rays) as $ray)
                            <li class="text-gray-600">
                                @php
                                echo $ray;
                                @endphp
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="capitalize text-gray-600 pb-2 font-semibold underline decoration-2">{{ __('Notes') }}:
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
    // console.log(data);
</script>

</html>