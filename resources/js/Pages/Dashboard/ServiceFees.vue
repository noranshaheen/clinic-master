<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("Service Fees Details") }}
            </template>
            <template #content>
                <table class="w-full" v-if="message === null">
                    <tr class="border" v-for="items in prescription[0].prescription_items">
                        <td v-if="items.service_fees !== null" class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{
                            items.drugs.name }}</td>
                        <td v-if="items.service_fees !== null" class="flex justify-start content-center items-center">
                            <span>
                                {{ items.service_fees }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Total") }}</th>
                        <td class="font-bold">{{ total }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Paid Service Fees") }}</th>
                        <td class="font-bold">{{ __(getPaidServiceFees(prescription[0])) }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Remains") }}</th>
                        <td class="font-bold">{{ getRemainingOfServiceFees() }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-3/5 text-center">{{ __("Pay") }}</th>
                    <tr class="border">
                        <jet-input id="type" type="number" class=" block w-full rounded" v-model="form.paid" />
                    </tr>
                    </tr>
                </table>
                <div v-else>
                    <p class="text-center text-red-600 my-5">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        <!-- {{ __("No Additional Payments Were Found") }} -->
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
        prescription: {
            default: null
        },
        // appointment_id: {
        //     default: null
        // }
    },
    data() {
        return {
            showDialog: false,
            total: 0,
            partialy_paid:0,
            message: null,
            form: this.$inertia.form({
                paid: 0,
                appointment: null
            }),
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            this.message = null;
            console.log(this.prescription);
            
            if (this.prescription !== null && this.prescription.length > 0) {
                this.form.appointment = this.prescription[0].appointment_id;
                this.getTotalServiceFees(this.prescription[0].prescription_items);
            }
            else {
                this.message = "Not Fount Any Additional Payments";
            }
            if (this.prescription[0].appointment.payment == null) {
                this.message = "You Have To Pay Detection Fees First";
            }
        },
        getTotalServiceFees(prescriptionItems) {
            var total = 0;
            prescriptionItems.forEach(el => {
                if (el.service_fees !== null) {
                    total += Number(el.service_fees);
                }
            });
            this.total = total;
        },
        getPaidServiceFees(prescription) {
            
            if (prescription.appointment.payment.service_fees) {
                this.partialy_paid =prescription.appointment.payment.service_fees;
                return this.partialy_paid;
            } else {
                return 'Not Paid'
            }
        },
        getRemainingOfServiceFees() {
            return this.total - this.partialy_paid;
        },
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