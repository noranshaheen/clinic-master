<template>
    <app-layout>
        <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg mx-4 px-4">
            <div class="p-1">
                <type-of-patient ref="dlg1" :appointment_id="selectedAppointemt_id" @Save="searchData()" />
                <choose-cancellation-method ref="dlg2" :doctor_id="cancelledAppointments.doctor_id"
                    :date="cancelledAppointments.date" @Save="searchData()" />
                <appointment-details ref="dlg3" :appointment_Details="appointment_Details"/>                

                <div class="my-2 flex justify-between">
                    <div class="w-3/5">
                        <div class="grid grid-cols-2 gap-8">
                            <!-- all doctors -->
                            <div class="text-lg">
                                <jet-label for="doctor-name" :value="__('Doctor')" />
                                <select id="doctor-name" v-model="form.doctor_id" class="mt-1 block w-full border-slate-300 rounded-md">
                                    <option v-for="doctor in allDoctors" :value="doctor.id" :key="doctor.id">
                                        {{ doctor.name }}
                                    </option>
                                </select>
                            </div>
                            <!-- select date -->
                            <div class="text-lg">
                                <jet-label for="date" :value="__('Date')" class="mt-4" />
                                <jet-input id="date" type="date" v-model="form.date" class="mt-1 block w-full text-sm" required />
                            </div>
                        </div>
                    </div>
                    <!-- search botton -->
                    <div class="w-1/5 flex flex-col justify-end items-end">
                        <jet-button id="search" @click="searchData()" class="text-lg w-1/2 h-1/2 md:flex justify-around">
                            <i class="fa-solid fa-magnifying-glass mx-1"></i>
                            <span>{{ __("Search") }}</span>
                        </jet-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-2 my-4">
            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg" v-if="Object.keys(appointments).length > 0">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
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
                            <td class="px-6 py-4 border dark:border-gray-700">
                                {{ appointment[0].doctor.name }}
                            </td>
                            <td class="p-4 text-center border dark:border-gray-700">
                                <div class="flex justify-start flex-wrap">
                                    <div v-for="apnt in appointment" :key="apnt.id" class="m-1">
                                        <jet-secondary-button v-if="apnt.patient_id == null"
                                            @click.prevent="openDlg('dlg1', apnt.id)"
                                            class="m-1 text-blue-500 border-blue-500 hover:bg-[#4099de] hover:text-white">
                                            {{ subtractHours(apnt.from,3) }}
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == null && apnt.done == null" 
                                        @click.prevent="showDetails(apnt.id)"
                                        class="m-1 text-neutral-300 border-neutral-300 hover:bg-[#b7d5ed] hover:text-white">
                                                <span>
                                                    {{ apnt.patient.name }}
                                                </span>
                                                <p>
                                                    {{ subtractHours(apnt.from,3) }}
                                                </p> 
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == null && apnt.done == 1" 
                                        @click.prevent="showDetails(apnt.id)"
                                        class="m-1 text-green-500 border-green-500 hover:bg-green-500 hover:text-white">
                                                <span>
                                                    {{ apnt.patient.name }}
                                                </span>
                                                <p>
                                                    {{ subtractHours(apnt.from,3) }}
                                                </p> 
                                        </jet-secondary-button>
                                        <jet-secondary-button v-else-if="apnt.cancelled == 1" 
                                        @click.prevent="showDetails(apnt.id)"
                                        class="m-1 text-red-200 border border-red-200 text-bold hover:bg-red-200 hover:text-white">
                                                {{ subtractHours(apnt.from,3) }} 
                                        </jet-secondary-button>
                                    </div>
                                </div>
                            </td>
                            <!-- :class="{'m-1 text-neutral-200 border-neutral-200 hover:bg-[#b7d5ed] hover:text-white' : apnt.cancelled==null },
                                        {'m-1 text-neutral-200 bg-red-100 border-neutral-200 hover:bg-[#b7d5ed] hover:text-white' : apnt.cancelled== 1 }" -->
                            <td class="border dark:border-gray-700 px-2 py-2">
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
            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg px-4 my-4 w-full bg-white" v-else>
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
            appointment_Details:"",
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
