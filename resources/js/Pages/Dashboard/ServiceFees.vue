<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("Service Fees Details") }}
            </template>
            <template #content>
                <table class="w-full" v-if="message === null">
                    <!-- <tr class="border" v-for="items in prescription[0].prescription_items">
                        <td v-if="items.service_fees !== null" class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{
                            items.drugs.name }}</td>
                        <td v-if="items.service_fees !== null" class="flex justify-start content-center items-center">
                            <span>
                                {{ items.service_fees }}
                            </span>
                        </td>
                    </tr> -->
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Total") }}</th>
                        <td class="font-bold">{{ total }}</td>
                    </tr>
                    <!-- <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Paid Service Fees") }}</th>
                        <td class="font-bold">{{ __(getPaidServiceFees(prescription[0])) }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Remains") }}</th>
                        <td class="font-bold">{{ getRemainingOfServiceFees() }}</td>
                    </tr> -->
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Pay") }}</th>
                    <tr class="border">
                        <jet-input id="type" type="number" class=" block w-full rounded" v-model="form.paid" />
                    </tr>
                    </tr>
                    <!-- <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Pay") }}</th>
                        <td class="font-bold">{{ __('Paid') }}</td>

                    </tr> -->
                    <tr>
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Reciever") }}</th>
                        <select id="type" v-model="form.current_team_id"
                            class="mt-1 block w-full border-slate-300 rounded-md text-sm"
                            @change="getAll(form.current_team_id)">
                            <option value="1">{{ __("Reseptionist") }}</option>
                            <option value="2">{{ __("Doctor") }}</option>
                        </select>
                    </tr>
                    <tr>
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Name") }}</th>
                        <select required v-model="form.doctor_id"
                            class="mt-1 block w-full border-slate-300 rounded-md text-sm" v-if="all_doctors.length != 0">
                            <option v-for="doctor in all_doctors" :value="doctor.id" :key="doctor.id">
                                {{ doctor.name }}
                            </option>
                        </select>
                        <select required v-model="form.reseptionist_id"
                            class="mt-1 block w-full border-slate-300 rounded-md text-sm"
                            v-if="all_reseptionists.length != 0">
                            <option v-for="reseptionist in all_reseptionists" :value="reseptionist.id"
                                :key="reseptionist.id">
                                {{ reseptionist.name }}
                            </option>
                        </select>
                    </tr>

                </table>
                <div v-else>
                    <p class="text-center text-red-600 my-5">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        {{ __(message) }}
                    </p>
                </div>
            </template>
            <template #footer>
                <JetButton class="ml-2" @click="save()">{{ __("Save") }}</JetButton>
                <JetSecondaryButton class="ml-2" @click="close()">{{ __("Close") }}</JetSecondaryButton>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import axios from "axios";

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetSecondaryButton,
        JetInput,
        axios

    },
    props: {
        // prescription: {
        //     default: null
        // },
        // payment: {
        //     default: 0
        // }
        appointment_id: {
            default: null
        },
        appointments_fees: {
            default: null
        },
    },
    data() {
        return {
            showDialog: false,
            total: 0,
            partialy_paid: 0,
            message: null,
            all_doctors: [],
            all_reseptionists: [],
            form: this.$inertia.form({
                paid: 0,
                appointment: null,
                reseptionist_id: "",
                doctor_id: "",
                current_team_id: "",
            }),
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            this.message = null;
            var total_fees = 0;
            // console.log(this.appointments_fees);
            this.form.appointment = this.appointment_id;

            total_fees = this.getRemaining(this.appointments_fees);

            if (total_fees == 0) {
                    this.message = "Not Fount Any Additional Payments";
            }
            else {
                this.total = total_fees
            }
        },
        getAll(team_id) {
            // console.log(team_id);
            if (team_id == 1) {
                axios
                    .get(route("reseptionist.all"))
                    .then((response) => {
                        this.all_doctors = [];
                        this.form.doctor_id = "";
                        this.all_reseptionists = response.data;
                        console.log(response.data);
                    })
            } else if (team_id == 2) {
                axios
                    .get(route("doctor.all"))
                    .then((response) => {
                        this.all_reseptionists = [];
                        this.form.reseptionist_id = "";
                        this.all_doctors = response.data;
                        console.log(response.data);
                    })
            }
        },
        getTotal(appointment) {
            var total = 0;
            var detectionFees = appointment.amount;
            if (appointment.fees) {
                var serviceFees = this.getTotalFees(appointment.fees);
            }
            total = Number(detectionFees) + Number(serviceFees);
            return total;
        },
        getTotalFees(fees) {
            var total = 0;
            fees.forEach((el) => {
                total += Number(el.price);
            })
            return total;
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

            this.appointments_fees.forEach((el) => {
                remaining += this.getTotal(el) - this.getTotalPaid(el.payments);
            })
            return remaining;
        },
        // getPaidServiceFees(prescription) {

        //     if (prescription.appointment.payment.service_fees) {
        //         this.partialy_paid = prescription.appointment.payment.service_fees;
        //         return this.partialy_paid;
        //     } else {
        //         return 'Not Paid'
        //     }
        // },
        // getRemainingOfServiceFees() {
        //     return this.total - this.partialy_paid;
        // },
        save() {
            // console.log(this.form);
            axios.post(route("payments.payServiceFees"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.close();
                }).catch((error) => {

                })
        },
        close() {
            this.showDialog = false;
            this.form.reset();
            this.total = 0;
            this.partialy_paid = 0;
            this.message = null;
        },
    }
}
</script>
<style></style>