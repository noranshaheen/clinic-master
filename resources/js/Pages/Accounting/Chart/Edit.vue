<template>
    <jet-dialog-modal :show="showDialog" maxWidth="2xl" @close="showDialog = false">
        <template #title>
            {{ __("Accounting Chart Dialog") }}
        </template>

        <template #content>
            <jet-validation-errors class="mb-4" />

            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1">
                    <jet-label :value="__('Code')" />
                    <jet-input id="id" type="text" class="mt-1 block w-full disabled:bg-gray-400" v-model="form.id"
                        :disabled="editingMode" />
                </div>
                <div class="col-span-1"></div>
                <div class="col-span-1">
                    <div class="w-full flex"><span class="m-auto">{{ __('Balance Sheet') }} </span></div>
                    <div class="w-full flex">
                        <jet-checkbox class="mt-4 m-auto" name="visible_balance_sheet" id="visible_balance_sheet"
                            v-model:checked="form.visible_balance_sheet" />
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="w-full flex"><span class="m-auto">{{ __('Income Statement') }} </span></div>
                    <div class="w-full flex">
                        <jet-checkbox class="mt-4 m-auto" name="visible_income_sheet" id="visible_income_sheet"
                            v-model:checked="form.visible_income_sheet" />
                    </div>
                </div>
                <div class="col-span-2">
                    <jet-label :value="__('Name')" />
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                </div>
                <div class="col-span-2">
                    <jet-label :value="__('Parent Account')" />
                    <multiselect v-model="parent_item" :options="items" :custom-label="nameWithCode" label="name"
                        track-by="id" @update:model-value="updateParentItem" :placeholder="__('Select item')" />
                </div>
                <div class="col-span-4">
                    <jet-label :value="__('Description')" />
                    <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                </div>

                <div class="col-span-4 grid grid-cols-12 gap-0 bg-gray-200">
                    <div class="col-span-3 ms-2">{{ __('Date') }}</div>
                    <div class="col-span-3 ms-2">{{ __('Debit Amount') }}</div>
                    <div class="col-span-3 ms-2">{{ __('Credit Amount') }}</div>
                    <div class="col-span-2 w-full flex">
                        <div class="m-auto">{{ __('Transferable') }}</div>
                    </div>
                    <div class="col-span-1 ms-2"></div>

                    <template v-for="(item, idx1) in form.balance">
                        <jet-input type="date" class="col-span-3 mt-1" v-model="item.balance_date" />
                        <jet-input type="number" class="col-span-3 mt-1" v-model="item.debit" />
                        <jet-input type="number" class="col-span-3 mt-1" v-model="item.credit" />
                        <jet-checkbox class="col-span-2 m-auto" name="transferable" id="transferable"
                            v-model:checked="item.transferable" />
                        <jet-danger-button @click="deleteEntry(idx1)" class="mt-1">
                            {{ __("Delete") }}
                        </jet-danger-button>
                    </template>
                    <jet-button class="ps-2 col-span-12 mt-1" @click="addBalance" :disabled="form.processing">
                        {{ __("Add Balance") }}
                    </jet-button>
                </div>
            </div>
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
import Multiselect from "@suadelabs/vue3-multiselect";
import TextField from "@/UI/TextField.vue";

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
        Multiselect,
        TextField,
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
                parent_id: "",
                name: "",
                description: "",
                visible_balance_sheet: false,
                visible_income_sheet: false,
                status: "Active",
                balance: []
            }),
            editingMode: false,
            parent_item: null,
            items: [],
            showDialog: false,
        };
    },

    methods: {
        ShowDialog() {
            this.editingMode = this.accounting_item ? true : false;
            if (this.accounting_item !== null) {
                this.form.id = this.accounting_item.id;
                this.form.parent_id = this.accounting_item.parent ? this.accounting_item.parent.id : null;
                this.form.name = this.accounting_item.name;
                this.form.description = this.accounting_item.description;
                this.form.visible_balance_sheet = this.accounting_item.visible_balance_sheet;
                this.form.visible_income_sheet = this.accounting_item.visible_income_sheet;
                this.form.transferable = this.accounting_item.transferable;
                this.form.status = this.accounting_item.status;
                this.form.balance = this.accounting_item.balance;
                this.form.balance.forEach((element, idx) => {
                    this.form.balance[idx].balance_date = element.balance_date.slice(0, 10);
                });
            } else {
                this.form.balance = [];
            }
            this.showDialog = true;
            this.$nextTick(() => {
                if (this.form.parent_id != null && this.items != null) {
                    this.parent_item = this.items.find(
                        (option) => option.id === this.form.parent_id
                    );
                } else {
                    this.parent_item = null;
                }
                this.updateParentItem();
            });
        },
        CancelDlg() {
            this.showDialog = false;
        },
        submit() {
            if (!this.editingMode)
                this.form.status = "Active";
            //this.form.balance.forEach((element, idx) => {
            //    if (typeof this.form.balance[idx].transferable === "string")
            //        this.form.balance[idx].transferable = this.form.balance[idx].transferable == "true" ? 1 : 0;
            //});
            axios
                .post(route("accounting.chart.store"), this.form)
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
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;

                });
        },
        nameWithCode({ id, name }) {
            return id + ' - ' + name;
        },
        updateParentItem() {
            if (this.parent_item) {
                this.form.parent_id = this.parent_item.id;
            } else {
                this.form.parent_id = null;
            }
        },
        addBalance() {
            this.form.balance.push({ transferable: true, balance_date: new Date().toISOString().slice(0, 10), debit: 0, credit: 0 })
        },
        deleteEntry(idx1) {
            this.form.balance.splice(idx1, 1);
        }
    },
    created() {
        axios
            .get(route("accounting.chart.json"))
            .then((response) => {
                this.items = response.data;
                if (this.accounting_item != null) {
                    this.parent_item = this.items.find(
                        (option) => option.id === this.form.parent_id
                    );
                    this.updateParentItem();
                }
            })
            .catch((error) => { });
    },
};
</script>
