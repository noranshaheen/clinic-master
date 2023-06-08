<template>
    <jet-dialog-modal :show="showDialog" @close="showDialog = false">
        <template #title>
            {{ __("prescription Information") }}
        </template>

        <template #content>
            <!-- <jet-validation-errors class="mb-2" /> -->

            <div>
                <table class="w-full">
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Date") }}</td>
                        <td class="p-2">{{ new Date(prescription_detail[0].prescription.dateTimeIssued).toLocaleDateString()
                        }}</td>
                    </tr>
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Diagnosis") }}</td>
                        <td class="p-2">
                            <ul class="list-disc list-inside">
                                <li v-for="diagnosis in JSON.parse(prescription_detail[0].prescription.diagnosis)">
                                {{ diagnosis }}
                                </li>
                            </ul>
                            
                        </td>
                    </tr>
                    <tr class="border" v-if="JSON.parse(prescription_detail[0].prescription.rays).length > 0">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("X-ray") }}</td>
                        <td class="p-2">
                            <ul class="list-disc list-inside">
                                <li v-for="rays in JSON.parse(prescription_detail[0].prescription.rays)">
                                    {{ rays }}
                                </li>
                            </ul>

                        </td>
                    </tr>
                    <tr class="border" v-if="JSON.parse(prescription_detail[0].prescription.analysis).length > 0">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Analysis") }}</td>
                        <td class="p-2">
                            <ul class="list-disc list-inside">
                                <li v-for="analysis in JSON.parse(prescription_detail[0].prescription.analysis)">
                                    {{ analysis }}
                                </li>
                            </ul>

                        </td>
                    </tr>
                    <tr class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Drugs") }}</td>
                        <td class="p-2">
                            <ul class="list-disc list-inside">
                                <li v-for="prescription in prescription_detail" :key="prescription.id">
                                {{ prescription.drugs.name + ' - ' + prescription.dose }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr v-if="prescription_detail[0].prescription.notes" class="border">
                        <td class="p-2 font-bold text-center bg-[#f8f9fa]">{{ __("Notes") }}</td>
                        <td class="p-2">{{ prescription_detail[0].prescription.notes }}</td>
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
        prescription: {
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
            if (this.prescription != null) {
                axios
                    .get(route("prescriptionItems.details", this.prescription.id))
                    .then((response) => {
                        console.log(response.data);
                        this.prescription_detail = response.data;
                        this.showDialog = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },
        CancelAddcustomer() {
            this.showDialog = false;
        },
    },
};
</script>
