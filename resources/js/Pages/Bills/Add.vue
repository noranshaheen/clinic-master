<template>
    <app-layout>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 pb-4 pt-0">
                    <div class="grid lg:grid-cols-3 gap-4 sm:grid-cols-1 h-1/2 overflow">
                        <div class="">
                            <jet-label :value="__('Clinic')" />
                            <multiselect v-model="form.clinic" label="name" :options="clinics"
                                placeholder="Select branch" />
                        </div>
                        <div class="">
                            <jet-label :value="__('Doctor')" />
                            <multiselect v-model="form.doctor" label="name" :options="doctors"
                                placeholder="Select doctor" />
                        </div>
                        <div class="">
                            <TextField v-model="form.date" itemType="date" :itemLabel="__('Bill Date')" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <!-- <div class="grid grid-cols-10 gap-0 mt-2">
                            <div class="bg-gray-200 col-span-3">
                                {{ __("Item") }}
                            </div>
                            <div class="bg-gray-200 col-span-1">
                                {{ __("Unit Price") }}
                            </div>
                            <div class="bg-gray-200 col-span-1">
                                {{ __("Quantity") }}
                            </div>
                            <div class="bg-gray-200 col-span-1">
                                {{ __("Sales Total") }}
                            </div>
                            <div class="bg-gray-200 col-span-1">
                                {{ __("Net Total") }}
                            </div>
                            <div class="bg-gray-200 col-span-1">
                                {{ __("Tax Items") }}
                            </div>
                            <div class="bg-gray-200 col-span-1"></div>
                            <div class="bg-gray-200 col-span-1"></div>
                            <template v-for="(item, idx1) in form.invoiceLines">
                                <jet-label class="mt-2 col-span-3">{{
                                    item.item.codeNamePrimaryLang
                                }}</jet-label>
                                <jet-label class="mt-2 col-span-1">{{
                                    item.unitValue.amountEGP
                                }}</jet-label>
                                <jet-label class="mt-2 col-span-1">{{
                                    item.quantity
                                }}</jet-label>
                                <jet-label class="mt-2 col-span-1">{{
                                    item.salesTotal
                                }}</jet-label>
                                <jet-label class="mt-2 col-span-1">{{
                                    item.netTotal
                                }}</jet-label>
                                <div class="grid grid-cols-2 gap-1">
                                    <template v-for="(taxitem, idx1) in item.taxItems" :key="taxitem.key">
                                        <jet-label class="mt-2 col-span-2">{{
                                            getTaxStr(taxitem)
                                        }}</jet-label>
                                        <jet-label class="mt-2 col-span-2">{{ taxitem.value }}({{
                                            taxitem.percentage
                                        }}%)</jet-label>
                                    </template>
                                </div>
                                <jet-secondary-button @click="EditItem(item, idx1)" class="h-12 mt-2 ms-2">
                                    {{ __("Edit") }}
                                </jet-secondary-button>
                                <jet-danger-button @click="DeleteItem(idx1)" class="h-12 mt-2 ms-2">
                                    {{ __("Delete") }}
                                </jet-danger-button>
                            </template>
                            <jet-label class="col-span-8" v-if="!form.invoiceLines.length">
                                {{ __("Please Add at least one item") }}
                            </jet-label>
                        </div> -->
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>{{ __('Item') }}</th>
                                            <!-- <th>{{ __('Unit Price') }}</th> -->
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('total') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(billLine, idx) in form.billLines">
                                            <td>
                                                <TextField v-model="billLine.item" itemType="text" />
                                            </td>
                                            <!-- <td> -->
                                            <!-- <TextField v-model="billLine.unitPrice" itemType="number"/>  -->
                                            <!-- </td> -->
                                            <td>
                                                <TextField v-model="billLine.quantity" itemType="number" />
                                            </td>
                                            <td>
                                                <TextField v-model="billLine.total" itemType="number" />
                                            </td>
                                            <td>
                                                <jet-button class="ms-2" @click="DeleteItem(idx)">
                                                    {{ __("Delete Item") }}
                                                </jet-button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <jet-button class="ms-2" @click="AddItem()">
                                    {{ __("Add New Item") }}
                                </jet-button>
                            </div>
                            <h3 class="">
                                {{ __('Total Amount :') }}
                                <span>
                                    {{ totalAmount() }}
                                </span>
                            </h3>
                        </div>
                        <div class="flex items-center justify-end mt-20">
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
import axios from 'axios';

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
    props: {
    },
    data() {
        return {
            doctors: [],
            clinics: [],
            errors: [],
            form: this.$inertia.form({
                billLines: [],
                doctor: "",
                clinic: "",
                date: "",
                billTotalAmount: 0
            }),
        };
    },
    methods: {
        AddItem: function () {
            // console.log("add new item")
            this.form.billLines.push({
                item: "",
                quantity: 0,
                total: 0
            });
            // this.currentItem = {
            //     quantity: 1,
            //     totalTaxableFees: 0,
            //     discount: { amount: 0, rate: 0 },
            //     itemsDiscount: 0,
            //     valueDifference: 0,
            //     unitValue: { amountEGP: 0, amountSold: 0, currencySold: "EGP", currencyExchangeRate: 1 },
            // };
            // this.$nextTick(() => {
            //     this.$refs.dlg1.ShowDialog();
            // });
            // this.RecalculateTax();
        },
        DeleteItem: function (idx) {
            this.form.billLines.splice(idx, 1);
        },

        onCancel: function () {
            window.location.reload();
        },
        totalAmount() {
            var total = 0;
            if (this.form.billLines.length != 0) {
                this.form.billLines.forEach(line => {
                    total += Number(line.total);
                });
                this.form.billTotalAmount = total;
                return total;
            }
        },
        onSave: function () {
            axios
                .post(route("bills.store"), this.form)
                .then((response) => {
                    this.processing = false;
                    this.$nextTick(() => this.$emit("dataUpdated"));
                    this.form.reset();
                    this.form.processing = false;
                    this.tab_idx = 1;
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
        axios
            .get(route('doctor.all'))
            .then((response) => {
                this.doctors = response.data;
            })
        axios
            .get(route('clinic.all'))
            .then((response) => {
                this.clinics = response.data;
            })

    },
};
</script>
