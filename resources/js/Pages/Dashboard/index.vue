<template>
    <app-layout>
        <div class="py-8 container mx-auto">
            <type-of-patient ref="dlg1" :appointment_id="selectedAppointemt_id" @Save="searchData()"/>

            <div class="my-4 grid grid-cols-10 py-2 my-4 gap-4 mx-auto">
                <div class="col-span-8">
                    <div class="grid grid-cols-2 gap-8">
                        <!-- all doctors -->
                        <div class="">
                            <jet-label :value="__('Doctor')" />
                            <select v-model="form.doctor_id" class="mt-1 block w-full border-slate-300 rounded-md">
                                <option v-for="doctor in allDoctors" :value="doctor.id" :key="doctor.id">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>
                        <!-- select date -->
                        <div class="">
                            <jet-label :value="__('Date')" class="mt-4" />
                            <jet-input type="date" v-model="form.date" class="mt-1 block w-full text-sm" required />
                        </div>
                    </div>
                </div>
                <!-- search botton -->
                <div class="col-span-2 flex flex-col justify-end items-end py-1">
                    <div class="text-lg">
                        <jet-button @click="searchData()">
                            {{ __("Search") }}
                        </jet-button>
                    </div>
                </div>
            </div>

            <div>
                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg" v-if="appointments">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Doctor
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    All Appointments
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="appointment in appointments" :key="appointment.id" >
                                <td class="px-6 py-4" >
                                    {{ appointment[0].doctor.name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <jet-secondary-button v-for="apnt in appointment" :key="apnt.id"
                                            :disabled="apnt.patient_id"
                                            @click.prevent="openDlg('dlg1', apnt.id)"
                                            class="m-1 text-blue-500 border-blue-500 hover:bg-[#4099de] hover:text-white">
                                            {{ new Date(apnt.from).toLocaleTimeString() }}
                                        </jet-secondary-button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg my-4 bg-white" v-else>
                    <p class="text-center text-red-600 my-5">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        {{ __("No Records Were Found") }}
                    </p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import TypeOfPatient from "./TypeOfPatient.vue";
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
export default {
    components: {
        AppLayout,
        TypeOfPatient,
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
            appointments: [],
            selectedAppointemt_id: "",

        }
    },
    methods: {
        searchData() {
            axios
                .post(route('appointment.searchData'), this.form)
                .then((response) => {
                    this.appointments = response.data
                    console.log(response.data);
                })
        },
        openDlg(dlg, id) {
            this.selectedAppointemt_id = id;
            this.$refs[dlg].ShowDialog();
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
