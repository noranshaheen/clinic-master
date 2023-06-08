<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("service fees details") }}
            </template>
            <template #content>
                <table class="w-full">
                    <tr class="border" v-for="items in prescription.prescription_items">
                        <td v-if="items.service_fees !== null" class="bg-[#f8f9fa] p-2 w-1/3 text-center">{{
                            items.drugs.name }}</td>
                        <td v-if="items.service_fees !== null" class="flex justify-start content-center items-center">
                            <span>
                                {{ items.service_fees }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Total</th>
                        <td class="font-bold">{{ total }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Paid</th>
                    <tr class="border">
                        <jet-input id="type" type="number" class=" block w-full rounded" v-model="form.paid" />
                    </tr>
                    </tr>
                </table>
            </template>
            <template #footer>
                <JetButton class="ml-2" @click="save()">save</JetButton>
                <JetSecondaryButton class="ml-2" @click="close()">close</JetSecondaryButton>
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
            form: this.$inertia.form({
                paid: 0,
                appointment: this.appointment_id
            }),
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            console.log(this.prescription);
            this.form.appointment = this.appointment_id;
            this.getTotalServiceFees(this.prescription.prescription_items);


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