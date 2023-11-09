<template>
    <app-layout>
        <patient-info ref="dlg5" :patient="current_patient_info" />
        <show-prescription ref="dlg1" :prescription="prescription_details" />
        <add-analysis-dialog ref="dlg2" @Save="getAnalysis()" />
        <add-xrays-dialog ref="dlg3" @Save="getXray()" />
        <add-service-dialog ref="dlg4" @Save="getService()" />

        <div class="sm:py-2 mx-auto">
            <div class="mx-auto sm:px-4 lg:px-6">
                <div class="bg-white shadow-xl sm:rounded-lg px-2">
                    <div class="lg:grid lg:grid-cols-4">
                        <div class="md:mx-2 md:col-span-1 md:gap-4">
                            <div class="hidden lg:block lg:py-2">
                                <!-- <jet-label class="" :value='__("Select Clinic")' /> -->
                                <lable class="text-slate-700 font-bold">{{ __('Select Clinic') }}</lable>
                            </div>
                            <div class="flex justify-between text-sm">
                                <multiselect v-model="selected_clinic" label="name" :options="allClinics"
                                    :placeholder='__("Branch")' :searchable="true" class="my-2 sm:w-7/12 sm:m-2" />
                                <jet-button @click="getAppointments"
                                    class="my-2 sm:w-1/12 sm:m-2 lg:flex lg:justify-center lg:items-center">
                                    <i class="fa-solid fa-magnifying-glass mx-1 lg:mx-0"></i>
                                </jet-button>
                            </div>
                        </div>
                        <hr class="block lg:hidden" />
                        <div class="lg:col-span-3 lg:ms-2 lg:border-s-2 px-2 ">
                            <div class="sm:grid-cols-1 mt-2 lg:mt-0">
                                <!-- patients -->
                                <div class="">
                                    <div class=" lg:py-2 m-2 lg:m-0">
                                        <!-- <jet-label class="" :value='__("Patients")' /> -->
                                        <lable class="text-slate-700 font-bold">{{ __('Patients') }}</lable>

                                    </div>
                                    <div class="grid grid-cols-4 gap-2 lg:flex lg:justify-start lg:flex-wrap lg:m-2"
                                        v-if="appointments.length > 0">
                                        <div v-for="appointment in appointments" :key="appointment.patient_id"
                                            class="w-full lg:w-fit">
                                            <jet-button
                                                v-if="appointment.patient_id !== null && appointment.cancelled == null"
                                                :class="{ 'bg-green-400': appointment.done, }" class="w-full"
                                                @click.prevent="getHistory(appointment.patient_id, appointment.patient, appointment.id)">
                                                {{ appointment.patient.name }}
                                            </jet-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:grid lg:grid-cols-3 lg:gap-4 my-4">
                    <!-- medium screen -->
                    <div
                        class="hidden lg:block mb-4 pb-4 lg:pb-1 lg:mb-0 md:col-span-1 border-r-2 relative shadow-lg sm:rounded-lg bg-white">
                        <!-- <div>{{ __("History") }}</div> -->
                        <div class="h-full">
                            <div class="w-full flex items-center border-b border-gray-200">
                                <jet-button @click="tab_idx = 1" :disabled="tab_idx == 1" :isRounded="false"
                                    class="w-1/2 md:h-full">
                                    {{ __("Prescription") }}
                                </jet-button>
                                <jet-button @click="tab_idx = 2" :disabled="tab_idx == 2" :isRounded="false"
                                    class="w-1/2 md:h-full">
                                    {{ __("History") }}
                                </jet-button>
                            </div>

                            <jet-validation-errors class="mb-4 mt-4 px-2" />

                            <!-- start prescription -->
                            <div v-show="tab_idx == 1" class="px-2">
                                <div v-if="current_patient_name" class="mx-auto w-full mt-4 border border-[#eceeef]">
                                    <div class="text-center p-2 font-bold bg-[#f8f9fa] w-full">
                                        <i @click="getPatientInfo()"
                                            class="fa fa-exclamation-circle mr-2 cursor-pointer border rounded-full"></i>
                                        <span>{{ current_patient_name }}</span>
                                    </div>
                                </div>
                                <table class="w-full" v-if="current_patient_name">
                                    <!-- start diagnosis -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa] w-1/3">{{ __("Diagnosis") }}</td>
                                        <td class="p-2">
                                            <ul v-for="diagnosis in all_diagnosis" class="list-disc list-inside">
                                                <li v-if="diagnosis.selected">
                                                    {{ diagnosis.name }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end diagnosis -->
                                    <!-- start drugs -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Drugs") }}</td>
                                        <td class="p-2">
                                            <ul v-for="(line, idx) in form.prescriptionLines">
                                                <li class="mb-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-bold">{{ line.name }}</span>
                                                        <i class="fa fa-delete-left cursor-pointer text-red-500"
                                                            @click="deleteItem(idx, form.prescriptionLines)"></i>
                                                    </div>
                                                    <div>
                                                        <input list="doses" id="dose" v-model="line.dose" placeholder="dose"
                                                            class="border pl-2 mx-1 border-slate-300 rounded-md w-full">
                                                        <datalist id="doses">
                                                            <option v-for="dose in doses" :value="dose.name"></option>
                                                        </datalist>
                                                        <!-- <input type="text" v-model="line.cost" placeholder="cost"
                                                            class="w-2/5 border-slate-300 rounded-md" /> -->
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end drugs -->
                                    <!-- start service -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Service") }}</td>
                                        <td class="p-2">
                                            <ul v-for="service in form.services" class="list-disc list-inside">
                                                <li class="inline-block">
                                                    <div class="flex justify-between items-center">
                                                        <span>{{ service.name }}</span>
                                                        <input type="text" v-model="service.default_price"
                                                            class="w-2/5 border-slate-300 rounded-md" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end service -->
                                    <!-- start analysis -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Analysis") }}</td>
                                        <td class="p-2">
                                            <ul v-for="analysis in form.analysis" class="list-disc list-inside">
                                                <li>
                                                    {{ analysis }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end analysis -->
                                    <!-- start rays -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("X-ray") }}</td>
                                        <td class="p-2">
                                            <ul v-for="ray in form.rays" class="list-disc list-inside">
                                                <li>
                                                    {{ ray }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end rays -->
                                    <!-- start consumables -->
                                    <!-- <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">
                                            {{ __("Consumables") }}
                                            <ul v-for="(item, idx) in form.consumedItems">
                                                <li class="mb-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-bold">{{ item.name + " (" +
                                                            item.measurement_unit + ")" }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <input type="number" step="0.1" v-model="item.quantity"
                                                            placeholder="quantity"
                                                            class="w-1/2 mx-1 border-slate-300 rounded-md" />
                                                        <input type="text" placeholder="cost" v-model="item.selling_price"
                                                            class="w-1/2 border-slate-300 rounded-md" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr> -->
                                    <!-- end consumables -->
                                    <!-- start nots -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Notes") }}</td>
                                        <td class="p-2">{{ form.notes }}</td>
                                    </tr>
                                    <!-- end notes -->
                                </table>
                                <div v-else class="m-5">
                                    <p class="text-center text-red-600">
                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                        {{ __("Please select a patient") }}
                                    </p>
                                </div>
                                <div class="mt-4" v-if="current_patient_name">
                                    <div class="flex items-center justify-end">
                                        <jet-secondary-button @click="onCancel()">
                                            {{ __("Cancel") }}
                                        </jet-secondary-button>
                                        <jet-button class="ms-2" @click="onSave()">
                                            {{ __("Save") }}
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div v-show="tab_idx == 2" class="px-2 flex flex-col justify-between">
                                <div>
                                    <div v-if="current_patient_name" class="mx-auto w-full mt-4 border border-[#eceeef]">
                                        <div class="text-center p-2 font-bold bg-[#f8f9fa] w-full">
                                            <i @click="getPatientInfo()"
                                                class="fa fa-exclamation-circle mr-2 cursor-pointer border rounded-full"></i>
                                            <span>{{ current_patient_name }}</span>
                                        </div>
                                    </div>
                                    <div v-if="patient_history.length > 0" class="overflow-x-auto w-full">
                                        <table class="w-full mx-auto lg:max-w-full table-fixed">
                                            <thead class="text-center bg-gray-300">
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Date") }}</th>
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Diagnosis") }}
                                                </th>
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]"></th>
                                            </thead>

                                            <tbody>
                                                <tr v-for="patient in patient_history" :key="patient.id"
                                                    class="border border-[#eceeef]">
                                                    <td class="p-2 border border-[#eceeef]">
                                                        {{ new Date(patient.created_at).toLocaleDateString() }}</td>
                                                    <td class="p-2 border border-[#eceeef]">
                                                        <ul class="list-disc list-inside">
                                                            <li v-for="diagnosis in JSON.parse(patient.diagnosis)">
                                                                {{ diagnosis }}
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="text-center p-2 border border-[#eceeef]">
                                                        <secondary-button @click="openDlg(patient)">
                                                            <i class="fa fa-info fa-lg"></i>
                                                        </secondary-button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else class="my-4">
                                        <p class="text-center text-red-600">
                                            <i class="fa fa-exclamation-circle mr-1"></i>
                                            {{ __("No Records Were Found") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- start prescription -->
                    <div class="md:col-span-2 relative shadow-lg sm:rounded-lg bg-white md:p-4 p-1">

                        <div class="mb-4 pb-2 border-b-2 ">
                            <!-- <jet-label :value="__('Diagnosis')" class="font-bold" /> -->
                            <lable class="my-1 text-slate-700 font-bold">{{ __('Diagnosis') }}</lable>
                            <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                            <div class="flex justify-start flex-wrap my-4">
                                <button v-for="diagnosis in all_diagnosis" :key="diagnosis.id" class="my-2 mx-1">
                                    <input type="checkbox" class="peer sr-only" :id="diagnosis.name" name="diagnosis"
                                        :value="diagnosis.name" v-model="diagnosis.selected"
                                        @change="getDrugs(diagnosis)" />
                                    <label :for="diagnosis.name"
                                        class=" cursor-pointer p-2 rounded-md text-center text-sm border shadow peer-checked:bg-green-500">
                                        {{ diagnosis.name }}
                                    </label>
                                </button>
                            </div>
                        </div>

                        <div>

                            <!-- start adding drugs -->
                            <div class="my-4 pb-2 border-b-2">
                                <lable class="my-1 text-slate-700 font-bold">{{ __('Drug') }}</lable>
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div>
                                    <div v-if="temp_drugs.length != 0" class="inline">
                                        <button v-for="(drug, idx) in temp_drugs" class="my-2 mx-1">
                                            <input type="checkbox" class="peer sr-only" :id="drug.name" name="drug"
                                                :value="{ drg: drug, dose: null, cost: null }" v-model="checkedDrugs"
                                                @change="check(drug)" />
                                            <label :for="drug.name"
                                                class=" cursor-pointer p-2 text-sm rounded-md text-center border shadow peer-checked:bg-green-500">
                                                {{ drug.name }}
                                            </label>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end adding drugs -->

                            <!-- start adding services -->
                            <div class="my-4 pb-2 border-b-2">
                                <lable class="my-1 text-slate-700 font-bold">{{ __('Service') }}</lable>
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div v-if="service">
                                    <!-- <div v-if="all_services.length != 0" class="inline"> -->
                                    <button v-for="(service, idx) in all_services" class="my-2 mx-1">
                                        <input type="checkbox" class="peer sr-only" :id="service.name" name="service"
                                            :value="service" v-model="form.services" />
                                        <label :for="service.name"
                                            class=" cursor-pointer p-2 text-sm rounded-md text-center border shadow peer-checked:bg-green-500">
                                            {{ service.name }}
                                        </label>
                                    </button>
                                    <!-- </div> -->
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="addService()">
                                        <i class="fa fa-plus mr-1"></i>
                                    </jet-button>
                                    <jet-button class="ms-2" @click="AddNewService()">
                                        {{ __("Add") }}
                                    </jet-button>
                                </div>
                            </div>
                            <!-- end adding services -->

                            <!-- start adding analysis -->
                            <div class="my-2 pb-2 border-b-2 ">
                                <!-- <jet-label :value="__('Analysis')" class="font-bold" /> -->
                                <lable class="my-1 text-slate-700 font-bold">{{ __('Analysis') }}</lable>
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div v-if="analysis" class="flex justify-start flex-wrap">
                                    <button v-for="analysis in all_analysis" :key="analysis.id" class="my-2 mx-1">
                                        <input type="checkbox" class="peer sr-only" :id="analysis.name" name="analysis"
                                            :value="analysis.name" v-model="form.analysis" />
                                        <label :for="analysis.name"
                                            class=" cursor-pointer p-2 rounded-md text-sm text-center border shadow peer-checked:bg-green-500">
                                            {{ analysis.name }}
                                        </label>
                                    </button>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="AddAnalysis()">
                                        <i class="fa fa-plus mr-1"></i>
                                    </jet-button>
                                    <jet-button class="ms-2" @click="AddNewAnalysis()">
                                        {{ __("Add") }}
                                    </jet-button>
                                </div>
                            </div>
                            <!-- end adding analysis -->

                            <!-- start adding rays -->
                            <div class="my-2 pb-2 border-b-2">
                                <!-- <jet-label :value="__('X-ray')" class="font-bold"/> -->
                                <lable class="my-1 text-slate-700 font-bold">{{ __('X-ray') }}</lable>
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div v-if="rays" class="flex justify-start flex-wrap">
                                    <!-- <multiselect v-model="form.rays" label="name" :options="all_rays"
                                        placeholder="Select Ray" :searchable="true" :multiple="true" class="mt-2" /> -->
                                    <button v-for="rays in all_rays" :key="rays.id" class="my-2 mx-1">
                                        <input type="checkbox" class="peer sr-only" :id="rays.name" name="rays"
                                            :value="rays.name" v-model="form.rays" />
                                        <label :for="rays.name"
                                            class=" cursor-pointer p-2 rounded-md text-sm text-center border shadow peer-checked:bg-green-500">
                                            {{ rays.name }}
                                        </label>
                                    </button>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="AddRays()">
                                        <i class="fa fa-plus mr-1"></i>
                                    </jet-button>
                                    <jet-button class="ms-2" @click="AddNewXray()">
                                        {{ __("Add") }}
                                    </jet-button>
                                </div>
                            </div>
                            <!-- end adding rays -->

                            <!-- start notes -->
                            <div class="my-1">
                                <lable class="my-1 text-slate-700 font-bold">{{ __('Notes') }}</lable>
                                <div class="my-1">
                                    <input v-model="form.notes" type="text" class="w-full border border-gray-300 rounded" />
                                </div>
                            </div>
                            <!-- end notes -->
                        </div>
                    </div>

                    <!-- mobile screen -->
                    <div
                        class="lg:hidden mb-4 pb-4 lg:pb-1 lg:mb-0 mt-4 md:col-span-1 border-r-2 relative shadow-lg sm:rounded-lg bg-white">
                        <!-- <div>{{ __("History") }}</div> -->
                        <div class="h-full">
                            <div class="w-full flex items-center border-b border-gray-200">
                                <jet-button @click="tab_idx = 1" :disabled="tab_idx == 1" :isRounded="false"
                                    class="w-1/2 md:h-full">
                                    {{ __("Prescription") }}
                                </jet-button>
                                <jet-button @click="tab_idx = 2" :disabled="tab_idx == 2" :isRounded="false"
                                    class="w-1/2 md:h-full">
                                    {{ __("History") }}
                                </jet-button>
                            </div>
                            <div v-show="tab_idx == 1" class="px-2">
                                <div v-if="current_patient_name" class="mx-auto w-full mt-4 border border-[#eceeef]">
                                    <div class="text-center p-2 font-bold bg-[#f8f9fa] w-full">
                                        <i @click="getPatientInfo()"
                                            class="fa fa-exclamation-circle mr-2 cursor-pointer border rounded-full"></i>
                                        <span>{{ current_patient_name }}</span>
                                    </div>
                                </div>
                                <table class="w-full" v-if="current_patient_name">
                                    <!-- start diagnosis -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa] w-1/3">{{ __("Diagnosis") }}</td>
                                        <td class="p-2">
                                            <ul v-for="diagnosis in all_diagnosis" class="list-disc list-inside">
                                                <li v-if="diagnosis.selected">
                                                    {{ diagnosis.name }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end diagnosis -->
                                    <!-- start drugs -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Drugs") }}</td>
                                        <td class="p-2">
                                            <!-- {{form.checkedDrugs}} -->
                                            <ul v-for="(line, idx) in form.prescriptionLines">
                                                <li class="mb-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-bold">{{ line.name }}</span>
                                                        <i class="fa fa-delete-left cursor-pointer text-red-500"
                                                            @click="deleteItem(idx, form.prescriptionLines)"></i>
                                                    </div>
                                                    <!-- <multiselect v-model="line.dose" label="name" :options="doses"
                                                        placeholder="Dose" :searchable="true" class="text-sm" /> -->
                                                    <div class="flex justify-between">
                                                        <input list="doses" id="dose" v-model="line.dose" placeholder="dose"
                                                            class="border w-3/5 pl-2 mx-1 border-slate-300 rounded-md">
                                                        <datalist id="doses">
                                                            <option v-for="dose in doses" :value="dose.name"></option>
                                                        </datalist>
                                                        <!-- <input type="text" v-model="line.cost" placeholder="cost"
                                                            class="w-2/5 border-slate-300 rounded-md" /> -->
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end drugs -->
                                    <!-- start service -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Service") }}</td>
                                        <td class="p-2">
                                            <ul v-for="service in form.services" class="list-disc list-inside">
                                                <li>
                                                    <span>{{ service.name }}</span>
                                                    <input type="text" v-model="service.default_price"
                                                        class="w-2/5 border-slate-300 rounded-md" />
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end service -->
                                    <!-- start analysis -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Analysis") }}</td>
                                        <td class="p-2">
                                            <ul v-for="analysis in form.analysis" class="list-disc list-inside">
                                                <li>
                                                    {{ analysis }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end analysis -->
                                    <!-- start rays -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("X-ray") }}</td>
                                        <td class="p-2">
                                            <ul v-for="ray in form.rays" class="list-disc list-inside">
                                                <li>
                                                    {{ ray }}
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- end rays -->

                                    <!-- start nots -->
                                    <tr class="border">
                                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Notes") }}</td>
                                        <td class="p-2">{{ form.notes }}</td>
                                    </tr>
                                    <!-- end notes -->
                                </table>
                                <div v-else class="m-5">
                                    <p class="text-center text-red-600">
                                        <i class="fa fa-exclamation-circle mr-1"></i>
                                        {{ __("Please select a patient") }}
                                    </p>
                                </div>
                                <div class="mt-4" v-if="current_patient_name">
                                    <div class="flex items-center justify-end">
                                        <jet-secondary-button @click="onCancel()">
                                            {{ __("Cancel") }}
                                        </jet-secondary-button>
                                        <jet-button class="ms-2" @click="onSave()">
                                            {{ __("Save") }}
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div v-show="tab_idx == 2" class="px-2 flex flex-col justify-between">
                                <div>
                                    <div v-if="current_patient_name" class="mx-auto w-full mt-4 border border-[#eceeef]">
                                        <div class="text-center p-2 font-bold bg-[#f8f9fa] w-full">
                                            <i @click="getPatientInfo()"
                                                class="fa fa-exclamation-circle mr-2 cursor-pointer border rounded-full"></i>
                                            <span>{{ current_patient_name }}</span>
                                        </div>
                                    </div>
                                    <div v-if="patient_history.length > 0" class="overflow-x-auto w-full">
                                        <table class="w-full mx-auto lg:max-w-full table-fixed">
                                            <thead class="text-center bg-gray-300">
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Date") }}</th>
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Diagnosis") }}
                                                </th>
                                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]"></th>
                                            </thead>

                                            <tbody>
                                                <tr v-for="patient in patient_history" :key="patient.id"
                                                    class="border border-[#eceeef]">
                                                    <td class="p-2 border border-[#eceeef]">
                                                        {{ new Date(patient.created_at).toLocaleDateString() }}</td>
                                                    <td class="p-2 border border-[#eceeef]">
                                                        <ul class="list-disc list-inside">
                                                            <li v-for="diagnosis in JSON.parse(patient.diagnosis)">
                                                                {{ diagnosis }}
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="text-center p-2 border border-[#eceeef]">
                                                        <secondary-button @click="openDlg(patient)">
                                                            <i class="fa fa-info fa-lg"></i>
                                                        </secondary-button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else class="my-4">
                                        <p class="text-center text-red-600">
                                            <i class="fa fa-exclamation-circle mr-1"></i>
                                            {{ __("No Records Were Found") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>
  
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
  
<script>
import { computed, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import TextField from "@/UI/TextField.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import DialogInvoiceLine from "@/Pages/Invoices/EditLine.vue";
import axios from "axios";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import ShowPrescription from './Show.vue';
import AddAnalysisDialog from '../Analysis/Edit.vue';
import AddXraysDialog from '../XRays/Edit.vue';
import AddServiceDialog from '../Services/Edit.vue';
import PatientInfo from "@/Pages/Patients/Information.vue";
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

export default {
    components: {
        AppLayout,
        JetLabel,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        JetValidationErrors,
        DialogInvoiceLine,
        TextField,
        Multiselect,
        SecondaryButton,
        ShowPrescription,
        AddAnalysisDialog,
        AddXraysDialog,
        AddServiceDialog,
        PatientInfo
    },
    props: {
    },
    data() {
        return {
            //   clinics: [],
            //   doctors: [],
            tab_idx: 1,
            allClinics: [],
            selected_clinic: "",
            // allItems: [],
            prescription_details: "",
            appointments: [],
            current_patient_name: "",
            patient_history: [],
            drugs: [],
            temp_drugs: [],
            doses: [],
            durations: [],
            all_diagnosis: [],
            all_services: [],
            errors: [],
            analysis: false,
            all_analysis: [],
            all_rays: [],
            rays: false,
            service: false,
            checkedDiagnosis: [],
            checkedDrugs: [],
            current_patient_info: "",
            form: this.$inertia.form({
                appointment_id: "",
                patient_id: "",
                dateTimeIssued: new Date().toISOString().slice(0, 10),
                prescriptionLines: [],
                services: [],
                diagnosis: [],
                analysis: [],
                rays: [],
                notes: "",
                selected_clinic: null,
                // consumedItems: []
            }),
        };
    },
    methods: {
        getAppointments() {
            axios
                .get(route("appointment.today", this.selected_clinic.id))
                .then((response) => {
                    this.appointments = response.data;
                    console.log(response.data);
                })
                .catch((error) => { });
        },
        getDiagnosis() {
            axios
                .get(route('diagnosi.allSpeciatlyDiagnosis'))
                .then((response) => {
                    this.all_diagnosis = response.data;
                    console.log(response.data)
                })
        },
        getAnalysis() {
            axios
                .get(route('analysi.allSpeciatlyAnalysis'))
                .then((response) => {
                    this.all_analysis = response.data;
                    console.log(response.data)
                })
        },
        getXray() {
            axios
                .get(route('xray.allSpeciatlyRays'))
                .then((response) => {
                    this.all_rays = response.data;
                    console.log(response.data)
                })
        },
        AddNewService() {
            this.$nextTick(() => this.$refs.dlg4.ShowDialog());
        },
        getService() {
            axios
                .get(route("services.index"))
                .then((response) => {
                    this.all_services = response.data;
                })
                .catch((error) => { });
        },
        AddNewAnalysis() {
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
        },
        AddNewXray() {
            this.$nextTick(() => this.$refs.dlg3.ShowDialog());
        },
        getDrugs: function (diagnosis) {

            // this.temp_drugs.push(diagnosis.drugs);
            for (var i = 0; i < diagnosis.drugs.length; i++) {
                var drug_ids = this.temp_drugs.map((d) => { return d.id });
                if (this.temp_drugs.length != 0) {
                    if (!drug_ids.includes(diagnosis.drugs[i].id)) {
                        this.temp_drugs.push(diagnosis.drugs[i]);
                    } else {
                        continue;
                    }
                } else {
                    this.temp_drugs.push(diagnosis.drugs[i]);
                }

            }

            // var temp_diagnosis = this.all_diagnosis.filter((d) => d.selected);
            // var temp_diagnosis_ids = temp_diagnosis.map((e) => Object.values(e.drugList))

            // var temp1 = []
            // var temp2 = []

            // if (temp_diagnosis_ids.length != 0) {
            //     for (var i = 0; i < temp_diagnosis_ids.length; i++) {
            //         temp1 = this.drugs.filter((e) => { return temp_diagnosis_ids[i].includes(e.id) });
            //         for (var j = 0; j < temp1.length; j++) {
            //             if (temp2.length == 0) {
            //                 temp2.push(temp1[j]);
            //             } else {
            //                 var ids = temp2.map((e) => { return e.id })
            //                 if (!ids.includes(temp1[j].id)) {
            //                     temp2.push(temp1[j]);
            //                 } else {
            //                     continue;
            //                 }
            //             }
            //         }
            //     }
            //     this.temp_drugs = temp2;
            // } else {
            //     temp2 = []
            //     this.temp_drugs = temp2;
            // }

        },
        check: function (drug) {
            // console.log(drug)
            if (this.form.prescriptionLines.length == 0) {
                this.form.prescriptionLines.push(drug);
            } else {
                for (var i = 0; i < this.form.prescriptionLines.length; i++) {
                    var drug_ids = this.form.prescriptionLines.map((line) => { return line.id });
                    if (!drug_ids.includes(drug.id)) {
                        this.form.prescriptionLines.push(drug);
                    } else {
                        continue;
                    }
                }
            }


            // if (this.form.prescriptionLines.length == 0 || this.checkedDrugs.length == 0) {
            //     this.form.prescriptionLines = this.checkedDrugs;
            // } else {
            //     for (var i = 0; i < this.checkedDrugs.length; i++) {
            //         if (drug.id == this.checkedDrugs[i].drg.id) {
            //             continue;
            //         } else {
            //             this.form.prescriptionLines = this.checkedDrugs;
            //         }
            //     }
            // }
        },
        // AddItem: function (drug) {
        //     this.form.prescriptionLines.push({
        //         drug: drug,
        //         dose: "",
        //     });
        // },
        deleteItem: function (idx, arr) {
            arr.splice(idx, 1);
        },
        AddAnalysis: function () {
            this.analysis = true;
        },
        AddRays: function () {
            this.rays = true
        },
        addService: function () {
            this.service = true
        },
        nameWithId: function ({ id, name }) {
            return id + " - " + name;
        },
        openDlg(patient) {
            // console.log(patient);
            this.prescription_details = patient;
            this.$nextTick(() => this.$refs.dlg1.ShowDialog());
        },
        getHistory(patient_id, patient, appointment_id) {
            axios
                .get(route("patient.history", patient_id))
                .then((response) => {
                    console.log(response.data)
                    // this.current_patient_id = patient_id;
                    this.form.patient_id = patient_id;
                    if (response.data.length == 0) {
                        this.current_patient_info = patient;
                        this.patient_history = []
                    } else {
                        this.patient_history = response.data;
                        this.current_patient_info = ""
                    }
                    this.current_patient_name = patient.name;
                    this.form.appointment_id = appointment_id;
                })
        },
        // DeleteItem: function (idx) {
        //     this.form.prescriptionLines.splice(idx, 1);
        // },
        getPatientInfo() {
            // console.log(currentPatient);
            if (this.patient_history.length > 0) {
                this.current_patient_info = this.patient_history[0].patient;
            }
            this.$nextTick(() => this.$refs.dlg5.ShowDialog());

        },
        onCancel: function () {
            window.location.reload();
        },
        onSave: function () {
            var temp = this.all_diagnosis.filter((e) => e.selected)
            this.form.diagnosis = temp.map((e) => e.name);
            this.form.selected_clinic = this.selected_clinic;
            axios
                .post(route("prescriptions.store"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.processing = false;
                    this.form.reset();
                    this.form.processing = false;
                    this.temp_drugs = [];
                    this.getAppointments();
                    this.getDiagnosis();
                    this.getAnalysis();
                    // setTimeout(() => {
                    //     window.location.reload();
                    // }, 500);
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    // this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
    },
    created: function created() {
        // this.AddItem();
        // this.getAppointments();
        this.getDiagnosis();
        this.getAnalysis();
        this.getXray();
        this.getService();
        axios
            .get(route("drug.all"))
            .then((response) => {
                this.drugs = response.data;
            })
            .catch((error) => { });

        axios
            .get(route('doses'))
            .then((response) => {
                this.doses = response.data;
            })
        axios
            .get(route('durations'))
            .then((response) => {
                // console.log(response.data)
                this.durations = response.data;
            })
        axios
            .get(route('clinic.all'))
            .then((response) => {
                this.allClinics = response.data;
            })
        // axios
        //     .get(route('items.index'))
        //     .then((response) => {
        //         this.allItems = response.data;
        //         console.log("items", response.data);
        //     })
        // axios
        //     .get(route('json.analysis'))
        //     .then((response) => {
        //         this.all_analysis = response.data;
        //     })
        // axios
        //     .get(route('json.rays'))
        //     .then((response) => {
        //         this.all_rays = response.data;
        //     })
    },
};
</script>
  