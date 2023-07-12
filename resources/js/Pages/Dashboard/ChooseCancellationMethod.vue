<template>
    <div>
        <!-- <add-patient ref="dlg1" :appointment_id="appointment_id" @Save="save"/>
        <choose-patient ref="dlg2" :appointment_id="appointment_id" @Save="save"/> -->
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("Cancellation Method") }}
            </template>
            <template #content>
                <div class="flex flex-col justify-between items-center md:grid md:grid-cols-2 md:gap-8">
                    <jet-button class="w-full mb-2 md:h-full" @click="cancelAll()" >{{ __("cancel all appointments") }}</jet-button>
                    <jet-button class="w-full mb-2 md:h-full" @click="cancelUnreserved()" >{{ __("cancel unreserved appointments") }}</jet-button>
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
// import AddPatient from "@/Pages/Patients/Edit.vue";
// import ChoosePatient from "./ChoosePatient.vue";

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
        },
        date: {
            defult:null
        }

    },
    data() {
        return {
            showDialog: false,
            cancelledPatients:[]
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
            // console.log(this.doctor_id , this.date)
        },
        cancelAll() { 
            swal({
                title: this.__("Are you sure?"),
                text: this.__("Once approved it will cancel all appointments in date")+" "+this.date,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((approved) => {
                if (approved) {
                    axios
                        .post(route("appointment.cancel.all"),{ date: this.date, doctor_id: this.doctor_id })
                        .then((response) => {
                            swal({
                                title: this.__("all appointments have been cancelled"),
                                icon: "success",
                            }).then((approve) => {
                                this.showDialog = false;
                                this.$emit('Save');
                            })
                    })
                }
            })
        },
        cancelUnreserved() {
            swal({
                title: this.__("Are you sure?"),
                text: this.__("Once approved it will cancel unreserved appointments in date")+" "+this.date,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((approved) => {
                if (approved) {
                    axios
                        .post(route("appointment.cancel.unreserved"),{ date: this.date, doctor_id: this.doctor_id })
                        .then((response) => {
                            swal({
                                title: response.data,
                                icon: "success",
                            }).then((approve) => {
                                this.showDialog = false;
                                this.$emit('Save');
                            })
                    })
                }
            })
        },

    }
}
</script>
<style></style>