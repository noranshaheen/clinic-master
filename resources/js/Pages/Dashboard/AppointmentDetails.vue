<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("appointment details") }}
            </template>
            <template #content>
                <div v-if="appointment_Details[0].cancelled">
                    <p class="text-center text-red-600 my-5">
                    <i class="fa fa-exclamation-circle mr-1"></i>
                    {{ __("This appointment has been cancelled please contact with patient to let him know") }}
                </p>
                </div>
                <table class="w-full">
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Reservation Time</th>
                        <td class="pl-5">{{ new Date(appointment_Details[0].from).toLocaleTimeString() }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Patient Name</th>
                        <td class="pl-5">{{ appointment_Details[1].name }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Phone Number</th>
                        <td class="pl-5">{{ appointment_Details[1].phone }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Appointment Type</th>
                        <td class="pl-5">{{ appointment_Details[0].type }}</td>
                    </tr>
                    <tr class="border">
                        <th class="bg-[#f8f9fa] p-2 w-1/3 text-center">Payment Status</th>
                        <td class="pl-5">{{ appointment_Details[0].status }}</td>
                    </tr>
                </table>
            </template>
            <template #footer>
                <JetButton v-if="! appointment_Details[0].cancelled">pay</JetButton>
                <JetSecondaryButton class="ml-2" @click="close()">close</JetSecondaryButton>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetSecondaryButton

    },
    props: {
        appointment_Details: {
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
            console.log(this.appointment_Details);
        },
        close() {
            this.showDialog = false;
        },
    },
}
</script>
<style></style>