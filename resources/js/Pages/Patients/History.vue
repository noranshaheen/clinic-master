<template>
    <app-layout>
        <show-prescription ref="dlg1" :prescription="prescription_details" />
        <appointment-details ref="dlg3" :appointment_Details="appointment_Details" />
        <ServiceFees ref="dlg2" :prescription="prs" />
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 pb-4 pt-0">
                    <div class="my-4 font-bold">
                        <h2>{{ this.prescriptions[0].patient.name }}</h2>
                    </div>
                    <div class="flex justify-between items-center ms-0 mb-4 border-b border-gray-200">
                        <div>
                            <jet-button @click="tab_idx = 1" :disabled="tab_idx == 1" :isRounded="false">
                                {{ __("Payments") }}
                            </jet-button>
                            <jet-button @click="tab_idx = 2" :disabled="tab_idx == 2" :isRounded="false">
                                {{ __("Prescriptions") }}
                            </jet-button>
                        </div>
                        <div>
                            <span>{{ __('Remains') + " : "  }}</span>
                            <span>{{ getRemaining()}}</span>
                        </div>
                    </div>
                    <!--first tab-->
                    <div v-show="tab_idx == 1" class="overflow-auto">
                        <table class="w-full">
                            <tr>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Date") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Doctor") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Detection Type") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Detection Fees") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Total Service Fees") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Total") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Paid") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Actions") }}</th>
                            </tr>
                            <tr v-for="appointment  in appointments" :key="appointment.id">
                                <td class="text-center  border p-2">{{ new
                                    Date(appointment.date).toLocaleDateString() }}
                                </td>
                                <td class="text-center  border p-2">{{ __(appointment.doctor.name) }}</td>
                                <td class="text-center  border p-2">{{ __(appointment.type) }}</td>
                                <td class="text-center  border p-2">{{ appointment.amount }}</td>
                                <td class="text-center  border p-2"> {{ getTotalFees(appointment.fees) }}</td>
                                <td class="text-center  border p-2"> {{ getTotal(appointment) }}</td>
                                <td class="text-center  border p-2"> {{ getTotalPaid(appointment.payments) }}
                                </td>
                                <td class="text-center  border p-2">
                                    <JetButton @click="downloadPDF(appointment)">
                                        {{ __("Print") }}
                                    </JetButton>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--second tab-->
                    <div v-show="tab_idx == 2" class="overflow-auto">
                        <table class="w-full" v-if="this.prescriptions.length !== 0">
                            <tr>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Date") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Doctor") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Diagnose") }}</th>
                                <th class="bg-[#f8f9fa] p-3 border border-[#eceeef]">{{ __("Actions") }}</th>
                            </tr>
                            <tr v-for="prescription in prescriptions" :key="prescription.id">
                                <td class="text-center border py-2">{{ new
                                    Date(prescription.dateTimeIssued).toLocaleDateString() }}
                                </td>
                                <td class="text-center border py-2">{{ prescription.doctor.name }}</td>
                                <td class="text-center border py-2">
                                    <ul v-for="diagnose in JSON.parse(prescription.diagnosis)"
                                        class="list-disc list-inside">
                                        <li>{{ diagnose }}</li>
                                    </ul>
                                </td>
                                <td class="text-center border py-2">
                                    <div class="flex flex-col sm:flex-row justify-center items-center">
                                        <JetButton class="w-full sm:w-min" @click="downloadPrescriptionPDF(prescription)">
                                            {{ __("Print") }}</JetButton>
                                        <JetButton class="w-full sm:w-min" @click="openDlg(prescription)">{{ __("Show") }}
                                        </JetButton>
                                    </div>

                                </td>
                            </tr>
                        </table>
                        <div v-else>
                            <p class="text-center text-red-600">
                                <i class="fa fa-exclamation-circle mr-1"></i>
                                {{ __("No Records Were Found") }}
                            </p>
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
import ShowPrescription from "@/Pages/Prescriptions/Show.vue";
import ServiceFees from "@/Pages/Dashboard/ServiceFees.vue";
import AppointmentDetails from '@/Pages/Dashboard/AppointmentDetails.vue';
import axios from 'axios';

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
        ShowPrescription,
        ServiceFees,
        AppointmentDetails,
        axios
    },
    props: {
        // appointments: {
        //     default: null
        // },
        appointments: {
            default: null
        },
        prescriptions: {
            default: null
        }
    },
    data() {
        return {
            tab_idx: 1,
            // remainingBtn: false,
            errors: [],
            all_doctors: [],
            all_reseptionists: [],
            prescription_details: "",
            appointment_Details: "",
            prs: "",
            totalServiceFees: 0
        };
    },
    methods: {
        openDlg(patient) {
            // console.log(patient);
            this.prescription_details = patient;
            this.$nextTick(() => this.$refs.dlg1.ShowDialog());
        },
        getTotalFees(fees) {
            var total = 0;
            fees.forEach(element => {
                total += Number(element.price);
            });
            return total;
        },
        getTotal(appointment) {
            var serviceFees = this.getTotalFees(appointment.fees);
            var detectionFees = appointment.amount;
            var totalFees = Number(serviceFees) + Number(detectionFees);
            return totalFees;
        },
        getTotalPaid(payment) {
            var total = 0;
            payment.forEach(element => {
                total += Number(element.paid_amount);
            });
            return total;
        },
        getRemaining() {
            var remaining = 0;
            
            this.appointments.forEach((el) => {
                remaining += this.getTotal(el) - this.getTotalPaid(el.payments);
            })
            return remaining;
        },
        getReciever(payment) {
            // console.log(Object.keys(payment))
            if (payment.receiver_team_id == 1) {
                var receiver = this.all_reseptionists.find(el => el.id == payment.receiver_id)
                console.log(receiver.name)
                return receiver.name;
            }
            else if (payment.receiver_team_id == 2) {
                var receiver = this.all_doctors.find(el => el.id == payment.receiver_id)
                console.log(receiver.name)
                return receiver.name;
            }
        },
        // getReseptionist(res_id) {
        //     var receiver = null;
        //     axios.get(route('reseptionists.show', { reseptionist: res_id })).
        //         then((response) => {
        //             receiver = response.data;
        //         });
        //     if (receiver) {
        //         return receiver.name
        //     }
        // },
        // getDoctor(doc_id) {
        //     axios.get(route('doctors.show', { doctor: doc_id })).
        //         then((response) => {
        //             var receiver = response.data;
        //             return receiver.name;
        //         })
        // },
        // getPaidServiceFees(prescription) {
        //     if (prescription.appointment.payment.service_fees) {
        //         return prescription.appointment.payment.service_fees;
        //     } else {
        //         return 'Not Paid'
        //     }
        //     // console.log("paid service fees of prescription "+prescription.id)
        // },
        // getTotalServiceFees(prescription) {
        //     // console.log("total service fees of prescription "+prescription.id)
        //     var total = 0;
        //     prescription.prescription_items.forEach(element => {
        //         if (element.service_fees !== null) {
        //             total += Number(element.service_fees);
        //             // console.log(el.service_fees);
        //         }
        //     });
        //     this.totalServiceFees = total;
        //     return total;
        // },
        // getRemainingOfServiceFees(prescription) {
        //     // console.log(prescription)
        //     if (prescription.appointment.payment) {
        //         if (this.totalServiceFees != 0 && prescription.appointment.payment.service_fees !== null) {
        //             var paidFees = prescription.appointment.payment.service_fees;
        //             return this.totalServiceFees - Number(paidFees);
        //         } else if (prescription.appointment.payment.service_fees == null) {
        //             return this.totalServiceFees;
        //         }
        //     } else {
        //         return this.totalServiceFees;
        //     }
        // },
        // showRemainingBtn(prescription) {
        //     console.log(prescription)
        //     return true
        // },
        // payRemaining(prescription) {
        //     if (prescription.appointment.payment == null) {
        //         this.showDetails(prescription.appointment_id)
        //     } else {
        //         axios.get(route('prescription.serviceFees', prescription.appointment_id))
        //             .then((response) => {
        //                 this.prs = response.data;
        //                 this.$nextTick(() => {
        //                     this.$refs.dlg2.ShowDialog();
        //                 });
        //             })
        //     }
        // },
        showDetails(appointment_id) {
            axios
                .get(route('appointments.show', { appointment: appointment_id }))
                .then((response) => {
                    console.log(response.data);
                    this.appointment_Details = response.data;
                    this.$nextTick(() => {
                        this.$refs.dlg3.ShowDialog();
                    });
                })
        },
        downloadPDF(appointment) {
            // console.log(payment)
            window.open(route("pdf.payment.preview", appointment.id));
        },
        downloadPrescriptionPDF(prescription) {
            window.open(route("pdf.prescription.preview", prescription.id));
        },
    },
    created() {
        axios.get(route('reseptionist.all')).
            then((response) => {
                this.all_reseptionists = response.data
                console.log(response.data)
            })
        axios.get(route('doctor.all')).
            then((response) => {
                this.all_doctors = response.data
                console.log(response.data)
            })
        console.log("prescriptions", this.prescriptions)
        console.log("appointments", this.payments)

    },
};
</script>
