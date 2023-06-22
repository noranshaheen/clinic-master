<template>
    <div>
        <!-- <add-patient ref="dlg1" :appointment_id="appointment_id" @Save="save"/>
        <choose-patient ref="dlg2" :appointment_id="appointment_id" @Save="save"/> -->
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("Cancelled Patients") }}
            </template>
            <template #content>
                <div class="flex">
                    <jet-button @click="cancelAll()" >{{ __("cancel all appointments") }}</jet-button>
                    <jet-button @click="cancelUnreserved()" >{{ __("cancel unreserved appointments") }}</jet-button>
                </div>

            </template>

        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import axios from "axios";
import swal from "sweetalert";

export default {
    components: {
        JetButton,
        JetDialogModal,
        axios,
        swal

    },
    props: {
        doctor_id: {
            default:null
        }
    },
    data() {
        return {
            showDialog: false,
            cancelledPatients:[]
        }
    },
   methods: {
    
   },
}
</script>
<style></style>