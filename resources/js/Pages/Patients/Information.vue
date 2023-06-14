<template>
    <jet-dialog-modal :show="showDialog" @close="showDialog = false">
        <template #title>
            {{ __("Pateint Information") }}
        </template>

        <template #content>
            <!-- <jet-validation-errors class="mb-2" /> -->

            <div>
                <table class="w-full">
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Name") }}</td>
                        <td class="p-2">{{ patient.name }}</td>
                    </tr>
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Age") }}</td>
                        <td class="p-2">{{ new Date().getFullYear() - new Date(patient.date_of_birth).getFullYear()
                        }}</td>
                    </tr>
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("General Information") }}</td>
                        <td class="p-2">
                            {{ patient.additionalInformation }}
                        </td>
                    </tr>
                </table>
            </div>

        </template>
        <template #footer>
            <div class="flex items-center justify-end">
                <jet-secondary-button @click="CancelAddcustomer()">
                    {{ __("Ok") }}
                </jet-secondary-button>
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import axios from 'axios';

export default {
    components: {
        JetActionMessage,
        JetActionSection,
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetDialogModal,
        JetFormSection,
        JetInput,
        JetCheckbox,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        JetValidationErrors,
    },

    props: {
        patient: {
            Type: Object,
            default: null,
        },
    },

    data() {
        return {
            prescription_detail: "",
            showDialog: false,
        };
    },

    methods: {
        ShowDialog() {
            console.log(this.patient)
            this.showDialog = true;
        },
        CancelAddcustomer() {
            this.showDialog = false;
        },
    },
};
</script>
