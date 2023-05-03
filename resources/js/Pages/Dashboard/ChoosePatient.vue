<template>
    <div>
        <jet-dialog-modal :show="showDialog" @close="showDialog=false" maxWidth="md">
            <template #title>{{ __("Choose Patient Dialog") }}</template>
            <template #content>
                <multiselect v-model="form.patient" label="name" :options="allPatients" :custom-label="nameWithCode"
                    :placeholder="__('Select Patient')" />
            </template>
            <template #footer>
                <jet-button @click="onSave()" class="m-1"> {{ __('Save') }} </jet-button>
                <jet-secondary-button @click="onCancel()" class="m-1"> {{ __('Cancel') }} </jet-secondary-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import axios from "axios";
import swal from "sweetalert";

export default {
    components: {
        JetButton,
        JetSecondaryButton,
        JetDialogModal,
        Multiselect
    },
    props: {
        appointment_id: {
            default: null
        }
    },
    data() {
        return {
            showDialog: false,
            form: this.$inertia.form({
                patient: ""
            }),
            allPatients: [],
            errors:[]
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true;
        },
        nameWithCode({ id, name }) {
            return id + " - " + name;
        },
        onSave() {
            if (this.form.patient == "") {
                swal("Please select a patient !", {
                    icon: "error",
                });
            } else {
                axios
                    .post(route('appointment.reserve', { appointment_id: this.appointment_id }), this.form.patient)
                    .then((response) => {
                        this.$store.dispatch("setSuccessFlashMessage", true);
                        this.showDialog = false;
                        this.$emit('Save');
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$page.props.errors = error.response.data.errors;
                        this.errors = error.response.data.errors;
                    })

            }
        },
        onCancel() {
            this.showDialog = false;
        },
    },
    created() {
        axios
            .get(route('patient.all'))
            .then((response) => {
                this.allPatients = response.data;
            })
    }
}
</script>
<style></style>