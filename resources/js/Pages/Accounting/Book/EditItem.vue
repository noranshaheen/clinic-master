<template>
    <jet-dialog-modal :closeable="false" :show="showDialog" maxWidth="2xl" @close="showDialog = false">
        <template #title>
            {{ __("Accounting Book Item Dialog") }}
        </template>

        <template #content>
            <jet-validation-errors class="mb-4" />
            <div class="flex items-center ms-0 mb-4 border-b border-gray-200">
                <jet-button @click="tab_idx = 1" :disabled="tab_idx == 1" :isRounded="false">
                    {{ __("Basic Data") }}
                </jet-button>
                <jet-button @click="tab_idx = 2" :disabled="tab_idx == 2" :isRounded="false">
                    {{ __("Entries") }}
                </jet-button>
                <jet-button @click="tab_idx = 3" :disabled="tab_idx == 3" :isRounded="false">
                    {{ __("Contributions") }}
                </jet-button>
            </div>
            <div v-show="tab_idx == 1" class="grid grid-cols-4 gap-4">
                <TextField class="col-span-2" v-model="form.reference_code" itemType="text"
                    :itemLabel="__('Book Reference Code')" />
                <TextField class="col-span-2    " v-model="form.transaction_date" itemType="datetime-local"
                    :itemLabel="__('Transaction Date')" />
                <TextField class="col-span-4" v-model="form.name" itemType="text" :itemLabel="__('Name')" />
                <TextField class="col-span-4" v-model="form.description" itemType="text"
                    :itemLabel="__('Book Description')" />
                <jet-label class="col-span-4" for="attachment" :value="__('Attachments')"></jet-label>
                <input type="file" class="mt-1 block w-full py-2 col-span-4" required accept=".pdf"
                    @input="form.attachment = $event.target.files[0]" />
            </div>
            <div v-show="tab_idx == 2" class="grid grid-cols-4 gap-4">
                <div class="col-span-4 grid grid-cols-10 gap-0">
                    <div class="col-span-5 ms-2">{{ __('Account') }}</div>
                    <div class="col-span-2 ms-2">{{ __('Debit Amount') }}</div>
                    <div class="col-span-2 ms-2">{{ __('Credit Amount') }}</div>
                    <div class="col-span-1 ms-2"></div>

                    <template v-for="(item, idx1) in form.entries">
                        <multiselect class="col-span-5  mt-1" v-model="item.account" label="name" :options="accounts"
                            :custom-label="nameWithCode" :placeholder="__('Select Account')" />
                        <jet-input type="number" class="col-span-2 mt-1" @update:model-value="updateData($event)"
                            v-model="item.debit" />
                        <jet-input type="number" class="col-span-2 mt-1" @update:model-value="updateData($event)"
                            v-model="item.credit" />
                        <jet-danger-button @click="deleteEntry(idx1)" class="mt-1">
                            {{ __("Delete") }}
                        </jet-danger-button>
                    </template>
                    <div class="col-span-5 ms-2 text-xl m-auto">{{ __('Total') }}</div>
                    <jet-input type="number" class="col-span-2 bg-gray-400" v-model="form.debit" :disabled="true" />
                    <jet-input type="number" class="col-span-2 bg-gray-400" v-model="form.credit" :disabled="true" />
                    <div />
                    <jet-button class="ps-2 col-span-10 mt-1" @click="addEntry" :disabled="form.processing">
                        {{ __("Add Entry") }}
                    </jet-button>
                </div>
            </div>
            <div v-show="tab_idx == 3" class="grid grid-cols-4 gap-4">
                <div class="col-span-4 grid grid-cols-10 gap-0">
                    <div class="col-span-10 ms-2 text-xl">{{ __('Bussiness Activities Contriubtion Percentages') }}</div>

                    <template v-for="(item, idx1) in form.activities">
                        <div class="col-span-6 ms-2 text-xl m-auto">{{ item.name }}</div>
                        <jet-input type="number" class="col-span-2 mt-1" @update:model-value="updateData($event)"
                            v-model="item.contribution_percentage" />
                        <jet-danger-button @click="setContribution(idx1, 100)" class="m-1 col-span-1">
                            {{ __("All") }}
                        </jet-danger-button>
                        <jet-danger-button @click="setContribution(idx1, 0)" class="m-1 col-span-1">
                            {{ __("None") }}
                        </jet-danger-button>
                    </template>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex items-center justify-end">
                <jet-secondary-button @click="CancelDlg()">
                    {{ __("Cancel") }}
                </jet-secondary-button>

                <jet-button class="ms-2" @click="submit" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing | input_error">
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
import { useForm } from '@inertiajs/vue3'

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
        book_item: {
            Type: Object,
            default: null,
        },
    },

    data() {
        return {
            errors: [],
            input_error: true,
            accounts: [],
            form: [],
            editingMode: false,
            showDialog: false,
            tab_idx: 1,
        };
    },

    methods: {
        ShowDialog() {
            this.form = useForm({
                id: null,
                name: "",
                description: "",
                reference_code: "",
                accounting_book_id: "",
                transaction_date: "",
                debit: "",
                credit: "",
                status: "Draft",
                approved_by: null,
                accepted_by: null,
                rejected_by: null,
                rejection_reason: "",
                entries: [],
                activities: [],
                attachment: [],
            });
            this.editingMode = this.book_item == null ? false : true;
            if (this.book_item !== null) {
                Object.keys(this.book_item).forEach((key) => {
                    this.form[key] = this.book_item[key];
                });
                this.form.transaction_date = this.form.transaction_date.slice(0, 16);
                this.form.activities.forEach((element) => {
                    element.contribution_percentage = element.pivot.contribution_percentage;
                    element.accounting_activity_id = element.id;
                });

            } else {
                // find active activities
                var activitiesCount = 0;
                this.activities.forEach(element => {
                    if (element.status == "Active")
                        activitiesCount++;
                });
                this.activities.forEach(element => {
                    this.form.activities.push({
                        accounting_activity_id: element.id, name: element.name,
                        contribution_percentage: element.status == "Active" ? Math.round(10000 / activitiesCount) / 100 : 0
                    });
                });
            }
            this.showDialog = true;
        },
        CancelDlg() {
            this.showDialog = false;
        },
        submit() {
            var invalidEntries = false;
            this.form.entries.forEach(element => {
                if (element.account == null)
                    invalidEntries = true;
            });
            if (invalidEntries) {
                swal({
                    title: this.__("Invalid Input"),
                    text: this.__("Please review the book entries"),
                    icon: "error",
                    dangerMode: true,
                })
                return;
            }
            this.form.post(route("accounting.book.item.store", route().params.book), {
                preserveScroll: true,
                onSuccess: () => {
                    this.showDialog = false;
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                },
                onerror: (error) => {
                    this.errors = error.response.data.errors;
                },
            });
        },
        addEntry() {
            this.form.entries.push({ account: null, name: "", code: "", debit: 0, credit: 0 });
            this.updateData();
        },
        deleteEntry(idx1) {
            this.form.entries.splice(idx1, 1);
            this.updateData();
        },
        updateData() {
            this.$nextTick(() => {
                this.form.credit = 0;
                this.form.debit = 0;
                var Contribution = 0;
                this.form.entries.forEach(element => {
                    this.form.credit += this.parse(element.credit);
                    this.form.debit += this.parse(element.debit);
                });
                this.form.activities.forEach(element => {
                    Contribution += this.parse(element.contribution_percentage);
                });
                this.input_error = (this.form.credit != this.form.debit || this.form.credit == 0 || Contribution != 100);
            });
        },
        nameWithCode({ id, name }) {
            return id + ' - ' + name;
        },
        setContribution(idx1, value) {
            var $oldValue = this.form.activities[idx1].contribution_percentage;
            this.form.activities[idx1].contribution_percentage = value;
            if (value == 100) {
                this.form.activities.forEach(element => {
                    if (element.id != this.form.activities[idx1].id)
                        element.contribution_percentage = 0;
                });
            }
            if (value == 0) {
                var $nonZeroCount = 0;
                this.form.activities.forEach(element => {
                    if (element.contribution_percentage > 0)
                        $nonZeroCount++;
                });
                var $portion = $oldValue / $nonZeroCount;
                this.form.activities.forEach(element => {
                    if (element.contribution_percentage > 0)
                        element.contribution_percentage += $portion;
                });
            }
            this.updateData();
        },
        fileSelected(e) {
            this.form.attachment = e.target.files[0];
        },
    },
    created() {
        axios
            .get(route("accounting.chart.json"))
            .then((response) => {
                this.accounts = response.data;
            })
            .catch((error) => { });
        axios
            .get(route("accounting.activity.json"))
            .then((response) => {
                this.activities = response.data;
            })
            .catch((error) => { });
    },
};
</script>
