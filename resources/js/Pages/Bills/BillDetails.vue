<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("Bill Details") }}
            </template>
            <template #content>
                <div class="overflow-auto">
                    <table class="w-full">
                        <thead class="text-center bg-gray-300">
                            <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">
                                {{ __('Item') }}
                            </th>
                            <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Unit') }}</th>
                            <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Price') }}</th>
                            <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Quantity') }}</th>
                            <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Total') }}</th>
                        </thead>
                        <tbody class="text-center border border-[#eceeef] w-5/12">
                            <tr v-for="row in bill_details" class="border border-[#eceeef]">
                                <td class="p-1 border border-[#eceeef]">
                                    {{ row.item.name }}
                                </td>
                                <td class="p-1 border border-[#eceeef]">
                                    {{ row.item.measurement_unit }}
                                </td>
                                <td class="p-1 border border-[#eceeef]">
                                    {{ row.purches_price }}
                                </td>
                                <td class="p-1 border border-[#eceeef]">
                                    {{ row.quantity }}
                                </td>
                                <td class="p-1 border border-[#eceeef]">
                                    {{ row.total }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </template>
            <template #footer>
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
        bill_details: {
            default: null
        }
    },
    data() {
        return {
            showDialog: false,
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            console.log(this.bill_details);
        },
        // subtractHours(date, hours) {
        //     var d = new Date(date);
        //     d.setHours(d.getHours() - hours);
        //     var exactTime = d.toLocaleTimeString();
        //     return exactTime;
        // },
        // additionalPayments(appointment_id) {
        //     axios.get(route('prescription.serviceFees', appointment_id))
        //         .then((response) => {
        //             this.prescription = response.data;
        //             this.form.appointment_id = appointment_id;
        //             this.$nextTick(() => {
        //                 this.$refs.dlg1.ShowDialog();
        //             });
        //             this.showDialog = false;
        //         })
        // },
        // save() {
        //     this.form.appointment_id = this.appointment_Details[0].id;
        //     axios.post(route("appointment.pay"), this.form)
        //         .then((response) => {
        //             this.$store.dispatch("setSuccessFlashMessage", true);
        //             this.close();
        //         }).catch((error) => {
        //         })
        // },
        close() {
            this.showDialog = false;
        },
    }
}
</script>
<style></style>