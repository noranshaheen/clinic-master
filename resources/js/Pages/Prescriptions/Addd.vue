<template>
    <app-layout>
        <jet-validation-errors class="mb-4 mt-4" />
        <div class="py-4 container mx-auto">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-0">
                    <div class="flex justify-around sm:grid-cols-1 mt-4">

                        <div class=" w-3/5 mr-2">
                            <jet-label :value='__("Patient")' />
                            <multiselect v-model="form.patient" label="id" :options="patients" placeholder="Select Patient"
                                searchable="true" :custom-label="nameWithId" track-by="id" />
                        </div>

                        <div class="w-2/5 ml-2">
                            <TextField v-model="form.dateTimeIssued" itemType="datetime-local" itemLabel="Date Issued"
                                :value="new Date().toISOString()" />
                        </div>

                    </div>
                </div>

                <div>
                    <div class="relative shadow-lg sm:rounded-lg my-4 bg-white p-4"
                        v-if="form.prescriptionLines.length > 0">
                        <div>
                            <div class="grid grid-cols-7 gap-4 my-1">
                                <jet-label class="col-span-2" :value="__('Select Medicine')" />
                                <jet-label :value="__('Dosage')" />
                                <jet-label :value="__('Duration')" />
                                <jet-label :value="__('Notes')" />
                            </div>
                            <div v-for="(invLine, idx1) in form.prescriptionLines" :key="idx1"
                                class="grid grid-cols-7 gap-4">

                                <div class="col-span-2">
                                    <multiselect v-model="invLine.drug" label="name" :options="drugs" />
                                </div>

                                <div>
                                    <select v-model="invLine.dose"
                                        class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
                                        <option value="1">{{ "One Time" }}</option>
                                        <option value="2">{{ "Two Times" }}</option>
                                        <option value="3">{{ "Three Time" }}</option>
                                    </select>
                                </div>

                                <div>
                                    <select v-model="invLine.time"
                                        class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
                                        <option value="day">{{ "A Day" }}</option>
                                        <option value="week">{{ "A Week" }}</option>
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <TextField v-model="invLine.notes" itemType="text" />
                                </div>

                                <div>
                                    <div class="flex justify-end">
                                        <jet-danger-button @click="DeleteItem(idx1)" class="mt-2">
                                            {{ __("Delete") }}
                                        </jet-danger-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <jet-button class="ms-2" @click="AddItem()">
                            {{ __("Add Another Drug") }}
                        </jet-button>
                    </div>

                    <div class="flex items-center justify-start mt-20">
                        <jet-secondary-button @click="onCancel()">
                            {{ __("Cancel") }}
                        </jet-secondary-button>

                        <jet-button class="ms-2" @click="onSave()">
                            {{ __("Save") }}
                        </jet-button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
  
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
  
<script>
import { computed, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import TextField from "@/UI/TextField.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import DialogInvoiceLine from "@/Pages/Invoices/EditLine.vue";
import axios from "axios";

export default {
    components: {
        AppLayout,
        JetLabel,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        DialogInvoiceLine,
        TextField,
        Multiselect,
    },
    props: {},
    data() {
        return {
            // tab_idx: 1,
            //   clinics: [],
            //   doctors: [],
            patients: [],
            drugs: [],
            errors: [],
            form: this.$inertia.form({
                // doctor_id: "",
                patient: "",
                dateTimeIssued: new Date().toISOString().slice(0, 16),
                prescriptionLines: [],
            }),
        };
    },
    methods: {
        AddItem: function () {
            this.form.prescriptionLines.push({
                drug: "",
                dose: "",
                time: "",
                notes: "",
            });
            //   this.$nextTick(() => {
            //     this.$refs.dlg1.ShowDialog();
            //   });
        },
        nameWithId: function ({ id, name }) {
            return id + " - " + name;
        },
        DeleteItem: function (idx) {
            this.form.prescriptionLines.splice(idx, 1);
        },
        onCancel: function () {
            window.location.reload();
        },
        onSave: function () {
            axios
                .post(route("prescriptions.store"), this.form)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.processing = false;
                    this.form.reset();
                    this.form.processing = false;
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
    },
    created: function created() {
        // this.AddItem();
        axios
            .get(route("patient.all"))
            .then((response) => {
                this.patients = response.data;
            })
            .catch((error) => { });
        axios
            .get(route("drug.all"))
            .then((response) => {
                this.drugs = response.data;
            })
            .catch((error) => { });
    },
};
</script>
  