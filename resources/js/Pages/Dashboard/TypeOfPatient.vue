<template>
    <div>
        <add-patient ref="dlg1" :appointment_id="appointment_id" @Save="save" />
        <choose-patient ref="dlg2" :appointment_id="appointment_id" @Save="save" />
        <jet-dialog-modal :show="showDialog" @close="showDialog = false" maxWidth="md">
            <template #title>
                {{ __("which type of patients you are?") }}
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-8 mt-2">
                    <jet-button @click="openDlg('dlg1')">{{ __("Add New Patient") }}</jet-button>
                    <jet-button @click="openDlg('dlg2')">{{ __("Choose An Old Patient") }}</jet-button>
                </div>

            </template>

        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from "@/Jetstream/Button.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import AddPatient from "@/Pages/Patients/Edit.vue";
import ChoosePatient from "./ChoosePatient.vue";

export default {
    components: {
        JetButton,
        JetDialogModal,
        AddPatient,
        ChoosePatient

    },
    props: {
        appointment_id: {
            default: null
        },
    },
    data() {
        return {
            showDialog: false,
        }
    },
    methods: {
        ShowDialog() {
            this.showDialog = true
        },
        openDlg(dlg) {
            this.showDialog = false;
            this.$refs[dlg].ShowDialog();
        },
        save() {
            this.$emit('save')
        }
    }

}
</script>
<style></style>