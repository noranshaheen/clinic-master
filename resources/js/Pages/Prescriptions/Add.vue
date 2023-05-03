<template>
    <app-layout>

        <show-prescription ref="dlg1" :prescription="prescription_details" />

        <jet-validation-errors class="mb-4 mt-4" />

        <div class="py-4 container mx-auto">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-0">
                    <div class="flex justify-start sm:grid-cols-1 mt-4">

                        <div class="">
                            <jet-label class="py-4" :value='__("Patients")' />
                            <!-- <multiselect v-model="form.patient" label="id" :options="patients" placeholder="Select Patient"
                                :searchable="true" :custom-label="nameWithId" track-by="id"
                                /> -->
                            <div class="grid grid-cols-10 gap-4 my-2">
                                <div v-for="patient in patients" :key="patient.patient_id">
                                    <jet-button v-if="patient.patient_id" :class="{
                                            'bg-green-400': patient.done,
                                        }" @click.prevent="getHistory(patient.patient_id, patient.patient.name)">
                                        {{ patient.patient.name }}
                                    </jet-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">

                    <div class="border-r-2 col-span-1 relative shadow-lg sm:rounded-lg my-4 bg-white p-4">
                        <div v-if="current_patient_name" class="mx-auto w-11/12 my-1 border border-[#eceeef]">
                            <input class="text-center p-2 font-bold bg-[#f8f9fa] w-full" v-model="current_patient_name" />
                        </div>
                        <div v-if="patient_history.length > 0" class="my-5 overflow-x-auto w-full">
                            <table class="w-11/12 mx-auto lg:max-w-full">
                                <thead class="text-center bg-gray-300">
                                    <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Date") }}</th>
                                    <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Diagnosis") }}</th>
                                    <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]"></th>
                                </thead>

                                <tbody>
                                    <tr v-for="patient in patient_history" :key="patient.id"
                                        class="border border-[#eceeef]">
                                        <td class="p-2 border border-[#eceeef]">
                                            {{ new Date(patient.created_at).toLocaleDateString() }}</td>
                                        <td class="p-2 border border-[#eceeef]">
                                            <span class="block" v-for="diagnosis in JSON.parse(patient.diagnosis)">
                                                {{ "- " + diagnosis.name }}
                                            </span>
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
                        <div v-else>
                            <p class="text-center text-red-600 my-5">
                                <i class="fa fa-exclamation-circle mr-1"></i>
                                {{ __("No Records Were Found") }}
                            </p>
                        </div>
                    </div>


                    <div class="col-span-2 relative shadow-lg sm:rounded-lg my-4 bg-white p-4">

                        <div class="mb-4 pb-2 border-b-2">
                            <jet-label :value="__('Diagnosis')" />
                            <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                            <multiselect :options="all_diagnosis" label="name" :placeholder="__('Select Diagnosis')"
                                :multiple="true" v-model="form.diagnosis" class="mt-2"/>
                        </div>

                        <div>
                            <jet-label :value="__('Drug')" />
                            <!-- start adding drugs -->
                            <div class="my-4 pb-2 border-b-2 ">
                                <div class="grid grid-cols-7 gap-4 my-1" v-if="form.prescriptionLines.length != 0">
                                    <jet-label class="col-span-2 p-1" :value="__('Select Medicine')" />
                                    <jet-label class="col-span-2 p-1" :value="__('Dosage')" />
                                    <jet-label class="col-span-2 p-1" :value="__('Duration')" />
                                </div>

                                <div v-for="(invLine, idx1) in form.prescriptionLines" :key="idx1"
                                    class="grid grid-cols-7 gap-4">

                                    <div class="col-span-2">
                                        <multiselect v-model="invLine.drug" label="name" :options="drugs" />
                                    </div>

                                    <div class="col-span-2">
                                        <multiselect v-model="invLine.dose" label="name" :options="doses"
                                            placeholder="Dose" />
                                    </div>

                                    <div class="col-span-2">
                                        <multiselect v-model="invLine.time" label="duration" :options="durations"
                                            placeholder="Time" />
                                    </div>

                                    <div>
                                        <div class="flex justify-end">
                                            <jet-danger-button @click="DeleteItem(idx1)" class="mt-2">
                                                {{ __("Delete") }}
                                            </jet-danger-button>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="AddItem()">{{ __("Add Drug") }} </jet-button>
                                </div>
                            </div>
                            <!-- end adding drugs -->

                            <!-- start adding analysis -->
                            <div class="my-2 pb-2 border-b-2 ">
                                <jet-label :value="__('Analysis')" />
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div v-if="analysis">
                                    <multiselect v-model="form.analysis" label="name" :options="all_analysis"
                                        placeholder="Select Analysis" :searchable="true" :multiple="true" class="mt-2"/>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="AddAnalysis()">
                                        {{ __("Add Analysis") }}
                                    </jet-button>
                                </div>
                            </div>
                            <!-- end adding analysis -->

                            <!-- start adding rays -->
                            <div class="my-2 pb-2 border-b-2">
                                <jet-label :value="__('X-ray')" />
                                <span class="m-2 text-gray-400 text-sm">{{ __("(you can choose multiple options)") }}</span>
                                <div v-if="rays">
                                    <multiselect v-model="form.rays" label="name" :options="all_rays"
                                        placeholder="Select Ray" :searchable="true" :multiple="true" class="mt-2"/>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <jet-button class="ms-2" @click="AddRays()">
                                        {{ __("Add X-ray") }}
                                    </jet-button>
                                </div>
                            </div>
                            <!-- end adding rays -->

                            <!-- start notes -->
                            <div class="my-1">
                                <jet-label :value="__('Notes')" class="my-1" />
                                <div class="my-1">
                                    <input v-model="form.notes" type="text" class="w-full border border-gray-300 rounded" />
                                </div>
                            </div>
                            <!-- end notes -->
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-end mt-8">
                        <jet-secondary-button @click="onCancel()">
                            {{ __("Cancel") }}
                        </jet-secondary-button>
                        <jet-button class="ms-2" @click="onSave()">
                            {{ __("Save") }}
                        </jet-button>
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

export default {
    components: {
        AppLayout,
        JetLabel,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        DialogInvoiceLine,
        TextField,
        Multiselect,
        SecondaryButton,
        ShowPrescription,
    },
    props: {},
    data() {
        return {
            //   clinics: [],
            //   doctors: [],
            prescription_details: "",
            patients: [],
            current_patient_name: "",
            patient_history: [],
            drugs: [],
            doses: [],
            durations: [],
            all_diagnosis: [],
            errors: [],
            analysis: false,
            all_analysis: [],
            all_rays: [],
            rays: false,
            form: this.$inertia.form({
                // doctor_id: "",
                patient_id: "",
                dateTimeIssued: new Date().toISOString().slice(0, 16),
                prescriptionLines: [],
                diagnosis: [],
                analysis: [],
                rays: [],
                notes: ""
            }),
        };
    },
    methods: {
        getAppointments() {
            axios
                .get(route("appointment.today"))
                .then((response) => {
                    this.patients = response.data;
                    // console.log(response.data);
                })
                .catch((error) => { });
        },
        AddItem: function () {
            this.form.prescriptionLines.push({
                drug: "",
                dose: "",
                time: "",
                notes: "",
            });
        },
        AddAnalysis: function () {
            this.analysis = true;
        },
        AddRays: function () {
            this.rays = true
        },
        nameWithId: function ({ id, name }) {
            return id + " - " + name;
        },
        openDlg(patient) {
            console.log(patient);
            this.prescription_details = patient;
            this.$nextTick(() => this.$refs.dlg1.ShowDialog());
        },
        getHistory(patient_id, patient_name) {
            axios
                .get(route("patient.history", patient_id))
                .then((response) => {
                    // console.log(patient_name)
                    // this.current_patient_id = patient_id;
                    this.form.patient_id = patient_id;
                    this.patient_history = response.data;
                    this.current_patient_name = patient_name;
                })
        },
        DeleteItem: function (idx) {
            this.form.prescriptionLines.splice(idx, 1);
        },
        onCancel: function () {
            window.location.reload();
        },
        onSave: function () {
            axios
                .post(route("prescriptions.store"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.processing = false;
                    this.form.reset();
                    this.form.processing = false;
                    this.getAppointments();
                    // setTimeout(() => {
                    //     window.location.reload();
                    // }, 500);
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
    },
    created: function created() {
        // this.AddItem();
        this.getAppointments();
        axios
            .get(route("drug.all"))
            .then((response) => {
                this.drugs = response.data;
            })
            .catch((error) => { });
        axios
            .get(route('json.Diagnosis'))
            .then((response) => {
                this.all_diagnosis = response.data;
            })
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
            .get(route('json.analysis'))
            .then((response) => {
                this.all_analysis = response.data;
            })
        axios
            .get(route('json.rays'))
            .then((response) => {
                this.all_rays = response.data;
            })
    },
};
</script>
  