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
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{ __("Total") }}</th>
                        <td class="font-bold">{{ total }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{ __("Pay") }}</th>
                    <tr class="border">
                        <jet-input id="type" type="number" class=" block w-full rounded" v-model="form.paid" />
                    </tr>
                    </tr>
                </table>
                <div v-else>
                    <p class="text-center text-red-600 my-5">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        {{ __("No Additional Payments Were Found") }}
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
        appointment_id: {
            default: null
        }
    },
    data() {
        return {
            showDialog: false,
            total: "",
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
            this.form.appointment = this.appointment_id;
            if (this.prescription !== null && this.prescription.length > 0) {
                this.getTotalServiceFees(this.prescription[0].prescription_items);
            } else {
                this.message = "Not Fount Any Additional Payments";
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
        save() {
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
        },
    }
}
</script>
<style></style>