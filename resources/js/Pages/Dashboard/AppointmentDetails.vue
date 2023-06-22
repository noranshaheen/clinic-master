<template>
    <ServiceFees ref="dlg1" :prescription="prescription" :appointment_id="form.appointment_id"/>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = amount = false" maxWidth="md">
            <template #title>
                {{ __("Appointment Details") }}
            </template>
            <template #content>
                <div v-if="appointment_Details[0].cancelled">
                    <p class="text-center text-red-600 my-5">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        {{ __("This appointment has been cancelled please contact with patient") }}
                    </p>
                </div>
                <table class="w-full">
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{__("Reservation Time")}}</th>
                        <td class="pl-5">{{ subtractHours(appointment_Details[0].from, 3) }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{__("Patient Name")}}</th>
                        <td class="pl-5">{{ appointment_Details[1].name }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{__("Phone Number")}}</th>
                        <td class="pl-5">{{ appointment_Details[1].phone }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{__("Appointment Type")}}</th>
                        <td class="pl-5">{{ appointment_Details[0].type }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{ __("Payment Status") }}</th>
                        <td class="pl-5">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-green-500" v-if="appointment_Details[0].status == 'paid'">
                                    {{ __(appointment_Details[0].status) }}
                                </span>
                                <span class="font-bold text-red-500" v-if="appointment_Details[0].status == 'hold'">
                                    {{ __(appointment_Details[0].status) }}
                                </span>
                                <JetButton
                                    v-if="appointment_Details[0].amount == null && appointment_Details[0].cancelled == null"
                                    @click=" amount = true" class="font-sm">
                                    {{ __("Pay")}}
                                </JetButton>
                                <JetButton
                                    v-else-if="appointment_Details[0].cancelled !== null || appointment_Details[0].amount !== null"
                                    :disabled="true" class="font-sm bg-green-400 ">
                                    {{ __("Pay")}}
                                </JetButton>
                            </div>
                        </td>
                    </tr>
                    <tr class="border" v-if="amount == true">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{ __("Payment Amount") }}</th>
                        <td class="px-5">
                            <jet-input id="type" type="text" class=" block w-full " v-model="form.amount" required />
                        </td>
                    </tr>
                    <tr class="border" v-if="appointment_Details[0].status == 'paid'">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{__("Payment Amount")}}</th>
                        <td class="px-5">
                            <jet-input id="type" type="text" class=" block w-full " :value="appointment_Details[0].amount"
                                :disabled="true" />
                        </td>
                    </tr>
                    <!-- <tr class="border" v-if="amount == true">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Notes</th>
                        <td class="px-5 py-2">
                            <jet-input id="type" type="text" class=" block w-full " 
                            v-model="form.notes"/>
                        </td>
                    </tr>
                    <tr class="border" v-if="appointment_Details[0].notes">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Notes</th>
                        <td class="px-5 py-2">
                            <jet-input id="type" type="text" class=" block w-full text-gray-400" 
                            :value="appointment_Details[0].notes" :disabled="true" />
                        </td>
                    </tr> -->
                </table>
                <JetSecondaryButton class="my-2" @click="additionalPayments(appointment_Details[0].id)">
                    {{ __("Additional Payments") }}
                </JetSecondaryButton>
            </template>
            <template #footer>
                <JetButton class="ml-2"
                    v-if="appointment_Details[0].amount == null && appointment_Details[0].cancelled == null" @click="save()">
                    {{__("Save")}}</JetButton>
                <JetButton class="ml-2" v-else :disabled="true">{{__("Save")}}</JetButton>
                <JetSecondaryButton class="ml-2" @click="close()">{{ __("Close") }}</JetSecondaryButton>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import ServiceFees from "./ServiceFees.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import axios from "axios";

export default {
    components: {
        ServiceFees,
        JetButton,
        JetDialogModal,
        JetSecondaryButton,
        JetInput,
        axios

    },
    props: {
        appointment_Details: {
            default: null
        }
    },
    data() {
        return {
            showDialog: false,
            amount: false,
            form: this.$inertia.form({
                amount: "",
                appointment_id: "",
                notes: ""
            }),
            prescription: []
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            console.log(this.appointment_Details);
        },
        subtractHours(date, hours) {
            var d = new Date(date);
            d.setHours(d.getHours() - hours);
            var exactTime = d.toLocaleTimeString();
            return exactTime;
        },
        additionalPayments(appointment_id) {
            axios.get(route('prescription.serviceFees', appointment_id))
                .then((response) => {
                    this.prescription = response.data;
                    this.form.appointment_id = appointment_id;
                    this.$nextTick(() => {
                        this.$refs.dlg1.ShowDialog();
                    });
                    this.showDialog = false;
                })
        },
        save() {
            this.form.appointment_id = this.appointment_Details[0].id;
            axios.post(route("appointment.pay"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.close();
                }).catch((error) => {
                })
        },
        close() {
            this.showDialog = false;
            this.amount = false;
            this.form.reset();
        },
    }
}
</script>
<style></style>