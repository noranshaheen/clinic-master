<template>
    <jet-dialog-modal :show="showDialog" maxWidth="sm" @close="showDialog = false">
        <template #title>
            {{ __("Accounting Activity Dialog") }}
        </template>

        <template #content>
            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                    <TextField class="col-span-2" v-model="form.id" itemType="text" :itemLabel="__('Code')"
                        :active="!editingMode" />
                    <TextField class="col-span-2" v-model="form.name" itemType="text" :itemLabel="__('Name')" />
                    <TextField class="col-span-2" v-model="form.description" itemType="text"
                        :itemLabel="__('Description')" />
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex items-center justify-end">
                <jet-secondary-button @click="CancelDlg()">
                    {{ __("Cancel") }}
                </jet-secondary-button>

                <jet-button class="ms-2" @click="submit" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    {{ __("Save") }}
                </jet-button>
            </div>
        </template>
    </jet-dialog-modal>
</template>

<script>

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
import Multiselect from "@suadelabs/vue3-multiselect";
import TextField from "@/UI/TextField.vue";

export default {
    components: {
        TextField,
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
        Multiselect,
    },

    props: {
        accounting_item: {
            Type: Object,
            default: null,
        },
    },

    data() {
        return {
            errors: [],
            form: this.$inertia.form({
                id: "",
                name: "",
                description: "",
                status: ""
            }),
            editingMode: false,
            showDialog: false,
        };
    },

    methods: {
        ShowDialog() {
            this.editingMode = this.accounting_item == null ? false : true;
            if (this.accounting_item !== null) {
                this.form.id = this.accounting_item.id;
                this.form.name = this.accounting_item.name;
                this.form.description = this.accounting_item.description;
                this.form.status = this.accounting_item.status;
            } else {
                this.form.id = "";
                this.form.name = "";
                this.form.description = "";
                this.form.status = "Active";
            }
            this.showDialog = true;
        },
        CancelDlg() {
            this.showDialog = false;
        },
        submit() {
            axios
                .post(route("accounting.activity.store"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.processing = false;
                    this.form.reset();
                    this.form.processing = false;
                    this.showDialog = false;
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                })
                .catch((error) => {
                    this.form.processing = false;
                    //this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;

                });
        },
    },
    created() {
    },
};
</script>
