<template>
    <app-layout>
        <type-of-patient ref="dlg1" :appointment_id="selectedAppointemt_id" @Save="searchData()" />
        <choose-cancellation-method ref="dlg2" :doctor_id="cancelledAppointments.doctor_id"
            :date="cancelledAppointments.date" @Save="searchData()" />
        <appointment-details ref="dlg3" :appointment_Details="appointment_Details" @Delete="searchData()"/>
        <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg m-1 p-1 md:mx-4 md:px-4">
            <div class="p-1">
                <div class="sm:flex justify-between">
                    <div class="sm:w-3/5">
                        <div class="sm:grid sm:grid-cols-2 sm:gap-8">
                            <!-- all doctors -->
                            <div class="mb-3 sm:mb-0 text-sm md:text-md">
                                <jet-label for="doctor-name" :value="__('Doctor')" class="md:inline-block lg:mt-4 font-bold" />
                                <select id="doctor-name" v-model="form.doctor_id"
                                    class="mt-1 block w-full border-slate-300 rounded-md">
                                    <option v-for="doctor in allDoctors" :value="doctor.id" :key="doctor.id">
                                        {{ doctor.name }}
                                    </option>
                                </select>
                            </div>
                            <!-- select date -->
                            <div class="mb-3 sm:mb-0 text-sm md:text-md">
                                <jet-label for="date" :value="__('Date')" class="md:inline-block lg:mt-4 font-bold" />
                                <jet-input id="date" type="date" v-model="form.date" class="mt-1 block w-full text-sm"
                                    required />
                            </div>
                        </div>
                    </div>
                    <!-- search botton -->
                    <div class="sm:w-1/5 flex flex-col justify-start items-center mt-2 
                    sm:justify-end sm:items-end sm:mt-0 mx-auto sm:mx-0">
                        <jet-button id="search" @click="searchData()"
                            class="text-sm text-center sm:w-1/2 sm:h-1/2 sm:flex justify-around sm:p-2">
                            <i class="fa-solid fa-magnifying-glass mx-1"></i>
                            <span class="hidden lg:inline">{{ __("Search") }}</span>
                        </jet-button>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-5 md:mx-4">
            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg" v-if="Object.keys(appointments).length > 0">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Doctor") }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Appointments") }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Actions") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="appointment in appointments"
                            :key="appointment.id">
                            <td class="px-2 md:px-6 md:py-4 border dark:border-gray-700 font-bold">
                                {{ appointment[0].doctor.name }}
                            </td>
                            <td class="text-sm text-center md:p-4 md:text-md border dark:border-gray-700">
                                <div class="flex justify-center sm:justify-start flex-wrap md:grid md:grid-cols-2 
                                            lg:grid-cols-4">
                                    <div v-for="apnt in appointment" :key="apnt.id" class="md:m-1">
                                        <jet-secondary-button v-if="apnt.patient_id == null"
                                            @click.prevent="openDlg('dlg1', apnt.id)"
                                            class="m-1 text-blue-500 border-blue-500 
                                            hover:bg-[#4099de] hover:text-white md:w-full">
                                            {{ subtractHours(apnt.from, 2) }}
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == null && apnt.done == null"
                                            @click.prevent="showDetails(apnt.id)"
                                            class="m-1 text-neutral-400 border-neutral-300 
                                            hover:bg-[#b7d5ed] hover:text-white md:w-full">
                                            <span class="hidden md:inline">
                                                {{ apnt.patient.name }}
                                            </span>
                                            <p>
                                                {{ subtractHours(apnt.from, 3) }}
                                            </p>
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == null && apnt.done == 1"
                                            @click.prevent="showDetails(apnt.id)"
                                            class="m-1 text-green-500 border-green-500 
                                            hover:bg-green-500 hover:text-white md:w-full">
                                            <span class="hidden md:inline">
                                                {{ apnt.patient.name }}
                                            </span>
                                            <p>
                                                {{ subtractHours(apnt.from, 3) }}
                                            </p>
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == 1"
                                            @click.prevent="showDetails(apnt.id)"
                                            class="m-1 text-red-200 border border-red-200 text-bold hover:bg-red-200 hover:text-white">
                                            {{ subtractHours(apnt.from, 3) }}
                                        </jet-secondary-button>
                                    </div>
                                </div>
                            </td>
                            <!-- :class="{'m-1 text-neutral-200 border-neutral-200 hover:bg-[#b7d5ed] hover:text-white' : apnt.cancelled==null },
                                        {'m-1 text-neutral-200 bg-red-100 border-neutral-200 hover:bg-[#b7d5ed] hover:text-white' : apnt.cancelled== 1 }" -->
                            <td class="border dark:border-gray-700 md:px-2 md:py-2">
                                <JetButton @click="openCancellationDialog(appointment[0].doctor_id, this.form.date)">
                                    {{ __("Cancel") }}
                                </JetButton>
                                <!-- <JetButton>
                                    {{ __("postpone") }}
                                </JetButton> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="relative overflow-x-auto shadow-lg 
            bg-white sm:rounded-lg w-full text-sm text-center">
                <p class="text-center text-red-600 my-5">
                    <i class="fa fa-exclamation-circle mr-1"></i>
                    {{ __("No Records Were Found") }}
                </p>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import TypeOfPatient from "./TypeOfPatient.vue";
import ChooseCancellationMethod from "./ChooseCancellationMethod.vue";
import AppointmentDetails from './AppointmentDetails.vue';
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import TextField from "@/UI/TextField.vue";
import axios from "axios";
import swal from "sweetalert";
export default {
    components: {
        AppLayout,
        TypeOfPatient,
        ChooseCancellationMethod,
        AppointmentDetails,
        JetActionMessage,
        JetActionSection,
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetDialogModal,
        JetFormSection,
        JetInput,
        JetCheckbox,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        JetValidationErrors,
        Multiselect,
        TextField,
    },

    data() {
        return {
            allDoctors: [],
            form: this.$inertia.form({
                doctor_id: "",
                date: ""
            }),
            appointment_Details: "",
            appointments: {},
            selectedAppointemt_id: "",
            cancelledAppointments: {
                doctor_id: "",
                date: ""
            },
        }
    },
    methods: {
        searchData() {
            axios
                .post(route('appointment.searchData'), this.form)
                .then((response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.appointments = response.data
                    } else {
                        this.appointments = {};
                    }
                    console.log(response.data);
                })
        },
        subtractHours(date, hours) {
            var d = new Date(date);
            d.setHours(d.getHours() - hours);
            var exactTime = d.toLocaleTimeString();
            return exactTime;
        },
        openDlg(dlg, id) {
            this.selectedAppointemt_id = id;
            this.$refs[dlg].ShowDialog();
        },
        showDetails(appointment_id) {
            axios
                .get(route('appointments.show', { appointment: appointment_id }))
                .then((response) => {
                    console.log(response.data);
                    this.appointment_Details = response.data;
                    this.$refs.dlg3.ShowDialog();
                })
        },
        openCancellationDialog(doctor_id, date) {
            this.cancelledAppointments.doctor_id = doctor_id;
            this.cancelledAppointments.date = date;
            this.$refs.dlg2.ShowDialog();
        },
    },
    created() {
        axios.get(route('doctor.all'))
            .then((response) => {
                var temp = [{ id: -1, name: "All" }];
                this.allDoctors = temp.concat(response.data)
            });
    }
};
</script>

<style></style>
